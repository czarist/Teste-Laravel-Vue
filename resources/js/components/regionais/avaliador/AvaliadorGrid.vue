<template>
    <div class="mt-4">
        <h5 class="col-12 d-flex justify-content-between">
            Área do avaliador - Avaliação do Trabalho DT, IJ e MESA
        </h5>
        <div class="col-12">
            <div class="card">
                <div class="card-body pb-2">
                    <div v-if="loading">
                        <h5 class="d-flex justify-content-center">Carregando...</h5>
                        <b-progress :value="value" :max="max" ></b-progress>
                    </div>
                   
                    <div class="row d-flex align-items-center mb-3" v-if="!loading">

                        <label class="invalid-feedback font-weight-bold">* Clique em "Buscar Categoria" para filtra os trabalhos para Itercom Júnior, Divisões Temáticas e Mesas </label>

                        <div class="input-group input-group-sm col-6 col-sm-6 col-md-6 col-lg-6 mb-1">
                            <div class="input-group-prepend mb-2">
                                <span class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                </span>
                            </div>

                            <v-select
                                class="flex-fill"
                                :name="`modalidade`"
                                :disabled="loading"
                                :options="divisoes_tematicas"
                                :reduce="divisoes_tematicas => divisoes_tematicas.id"
                                v-model="modalidade.modalidade_search"
                                label="descricao"
                                @input="get()"
                                placeholder="Buscar Categoria..."
                            >
                                <template #selected-option="{ descricao }">
                                    <em>{{ descricao}}</em>
                                </template>
                            </v-select>
                        </div>
                    </div>
                   
                    <div class="table-responsive scroll" ref="scroll" v-show="!loading && registros.length > 0">
                        <table class="table table-sm table-striped table-hover table-bordered" v-if="user">
                            <thead>
                                <tr>
                                    <th
                                        class="align-middle text-center"
                                        width="5%"
                                        @click="handleSort('id')">
                                        <i class="bi" :class="{
                                            'bi-funnel' : sort != 'id',
                                            'bi-sort-up-alt' : sort == 'id' && asc == true,
                                            'bi-sort-down-alt' : sort == 'id' && asc == false
                                        }"></i> Insc-Trab 
                                    </th>
                                    <th class="align-middle text-center" width="20%"> Titulo</th>
                                    <th class="align-middle text-center" width="10%">Categoria</th>
                                    <th
                                        class="align-middle text-center"
                                        width="10%"
                                        @click="handleSort('status_avaliador')">
                                        <i class="bi" :class="{
                                            'bi-funnel' : sort!= 'status_avaliador',
                                            'bi-sort-up-alt' : sort== 'status_avaliador' && asc == true,
                                            'bi-sort-down-alt' : sort== 'status_avaliador' && asc == false
                                        }"></i> Status Avaliador 
                                    </th>
                                    <th class="align-middle text-center" width="5%">PDF</th>
                                    <th class="align-middle text-center" width="5%">MENSAGEM P/ COORDENADOR</th>
                                    <th class="align-middle text-center" width="5%">AÇÂO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(registro, index) in registros" :key="index" v-on="find_avaliacoes(registro)">
                                    <td class="align-middle text-center">{{ registro && registro.submissao ? (registro.submissao.id +" / "+ registro.submissao.avaliacao ) : "NI" }}</td>
                                    <td class="align-middle text-center">{{ registro && registro.submissao ? registro.submissao.titulo : "NI" }}</td>
                                    <td class="align-middle text-center">{{ find_dt(registro.submissao) }}</td>
                                    <td class="align-middle text-center">
                                        <div v-if="registro && registro.avaliador_1 == user.id">                                    
                                            {{ registro ? registro.status_avaliador_1 : "NI" }}<br>
                                        </div>    
                                        <div v-if="registro && registro.avaliador_2 == user.id">                                    
                                            {{ registro ? registro.status_avaliador_2 : "NI" }}<br>
                                        </div>    

                                        <div v-if="registro && registro.avaliador_3 == user.id">                                    
                                            {{ registro ? registro.status_avaliador_3 : "NI" }}<br>
                                        </div>    

                                    </td>
                                    <td class="align-middle text-center">
                                        <div v-if="registro && registro.submissao && registro.submissao.link_trabalho">
                                            <button
                                                v-tooltip.bottom="{
                                                content: 'Visualizar Anexo',
                                                delay: 0,
                                                class: 'tooltip-custom tooltip-arrow'
                                                }"
                                                title="Visualizar Anexo"
                                                class="btn btn-primary"
                                                @click="visualizarAnexo(registro.submissao)"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM1.6 11.85H0v3.999h.791v-1.342h.803c.287 0 .531-.057.732-.173.203-.117.358-.275.463-.474a1.42 1.42 0 0 0 .161-.677c0-.25-.053-.476-.158-.677a1.176 1.176 0 0 0-.46-.477c-.2-.12-.443-.179-.732-.179Zm.545 1.333a.795.795 0 0 1-.085.38.574.574 0 0 1-.238.241.794.794 0 0 1-.375.082H.788V12.48h.66c.218 0 .389.06.512.181.123.122.185.296.185.522Zm1.217-1.333v3.999h1.46c.401 0 .734-.08.998-.237a1.45 1.45 0 0 0 .595-.689c.13-.3.196-.662.196-1.084 0-.42-.065-.778-.196-1.075a1.426 1.426 0 0 0-.589-.68c-.264-.156-.599-.234-1.005-.234H3.362Zm.791.645h.563c.248 0 .45.05.609.152a.89.89 0 0 1 .354.454c.079.201.118.452.118.753a2.3 2.3 0 0 1-.068.592 1.14 1.14 0 0 1-.196.422.8.8 0 0 1-.334.252 1.298 1.298 0 0 1-.483.082h-.563v-2.707Zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638H7.896Z"/>
                                                </svg>   
                                            </button>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button
                                            v-if="                                                
                                                registro && registro.status_coordenador && registro.status_coordenador != 'Aceito' &&
                                                registro && registro.status_coordenador && registro.status_coordenador != 'Recusado' ||
                                                registro && registro.status_coordenador && registro.status_coordenador == 'Em Análise' ||
                                                registro && registro.status_coordenador && registro.status_coordenador == 'Em avaliação'                                            
                                                "
                                            v-tooltip.bottom="{
                                                content: 'Chat',
                                                delay: 0,
                                                class: 'tooltip-custom tooltip-arrow'
                                            }"
                                            @click="resetModalChat(),getChatAvaliador(registro)"
                                            type="button"
                                            class="btn btn-sm btn-primary"
                                        >MENSAGEM P/ COORDENADOR
                                        </button>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="d-flex justify-content-center"
                                            v-if="
                                                registro && registro.status_coordenador && registro.status_coordenador != 'Aceito' &&
                                                registro && registro.status_coordenador && registro.status_coordenador != 'Recusado' ||
                                                registro && registro.status_coordenador && registro.status_coordenador == 'Em Análise' ||
                                                registro && registro.status_coordenador && registro.status_coordenador == 'Em avaliação' ||
                                                registro && !registro.status_coordenador
                                            "                                        
                                        >
                                            <span
                                                v-tooltip.bottom="{
                                                content: 'Status Avaliador',
                                                delay: 0,
                                                class: 'tooltip-custom tooltip-arrow'
                                                }"
                                                title="Status Avaliador"
                                                class="btn btn-outline-primary btn-sm mr-1"
                                                @click="StatusAvaliador(registro)"
                                            >Status Avaliador</span>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="alert alert-danger" role="alert" v-if="!loading && registros.length == 0">
                        <h4 class="alert-heading">Ops!</h4>
                        Nenhum encontrado.
                    </div>
                    <div class="d-flex justify-content-between pages mt-2" v-show="!loading">
                        <span v-show="!loading">registros: {{ total }}</span>
                        <span v-show="!loading">Página: {{ currentPage }} de {{ totalPages }}</span>
                    </div>
                </div>
            </div>
        </div>
        <status-avaliador-modal :selectedAvaliador="selectedAvaliador" :user="user"></status-avaliador-modal>
        <chat-avaliador-modal :selectedChat="selectedChat" :user="user" :mensagens="mensagens" :scroll.sync="scroll"></chat-avaliador-modal>
        <notifications group="submit" position="center bottom" />
    </div>
</template>

<script>
    import debounce from 'debounce'
    import GridMixin from '../../mixins/grid-mixin'
    import StatusAvaliadorModal from './StatusAvaliadorModal.vue'
    import ChatAvaliadorModal from './ChatAvaliadorModal.vue'

    export default {
        mixins: [GridMixin],
        components: {
            StatusAvaliadorModal:() => import('./StatusAvaliadorModal.vue'),
            ChatAvaliadorModal:() => import('./ChatAvaliadorModal.vue')
        },
        data() {
            return {
                value: 100,
                max: 100,
                page: 'avaliador',
                baseUrl: process.env.MIX_BASE_URL,
                loading: true,
                selectedIndicar: null,
                selectedAvaliador: null,
                selectedCoordenador: null,
                scroll: false,
                mensagens: [],
                coordenador: null,
                selectedChat: {
                    id: null,
                    avaliacao_id: null,
                    avaliador_id: null,
                    avaliador_id: null,
                    coordenador_id: null,
                    mensagem: null
                },
                toDelete: null,
                divisoes_tematicas: [],
                modalidade: {
                    modalidade_search : null,
                },
                statusAvaliador: [
                    { id: "Avaliado" , descricao: "Avaliado"},
                    { id: "Em Análise" , descricao: "Em Análise"},
                    { id: "Alteração Solicitada" , descricao: "Alteração Solicitada"},
                ],
                statusCoordenador: [
                    { id: "Avaliado" , descricao: "Avaliado"},
                    { id: "Em Análise" , descricao: "Em Análise"},
                    { id: "Alteração Solicitada" , descricao: "Alteração Solicitada"},
                ],
                searchType: { link: 'titulo', text: 'TITULO' }
            }
        },
        watch: {
            modalidade: {
                handler:function(newVal) {
                    this.modalidade_search = newVal.modalidade_search
                },
                deep:true
            }
        },
        methods: {
            resetModalChat() {
                this.selectedChat.id = null,
                this.selectedChat.avaliacao_id = null,
                this.selectedChat.avaliado_id = null,
                this.selectedChat.avaliador_id = null,
                this.selectedChat.coordenador_id = null,
                this.selectedChat.mensagem = null
            },
            async getChatAvaliador(avaliacao) {
                if(avaliacao && avaliacao.id) {
                    await axios.get(`${this.baseUrl}/coordenador/get/chat/avaliador/${avaliacao.id}`)
                    .then(res =>{
                        if(res.data.length > 0){

                            if(avaliacao.avaliador_1 != null && avaliacao.avaliador_1 == this.user.id){
                                var indexChat = 1
                            }

                            if(avaliacao.avaliador_2 != null && avaliacao.avaliador_2 == this.user.id){
                                var indexChat = 2
                            }

                            if(avaliacao.avaliador_3 != null && avaliacao.avaliador_3 == this.user.id){
                                var indexChat = 3
                            }

                            this.mensagens = res.data ;
                            this.selectedChat.avaliacao_id = (res.data && res.data[0]) ? res.data[0].avaliacao_id : avaliacao && avaliacao.id ? avaliacao.id : null
                            this.selectedChat.avaliador_id = this.user ? this.user.id : null;
                            this.selectedChat.avaliador = this.user ? this.user : null;
                            this.selectedChat.mensagem = null;
                            this.selectedChat.send_avaliador = indexChat ? indexChat : null
                            this.selectedChat.avaliacao = avaliacao ? avaliacao : null
                            this.$validator.reset('mensagens');


                        } else{
                            
                            this.mensagens = [];
                            this.selectedChat.id = avaliacao && avaliacao.id ? avaliacao.id : null
                            this.selectedChat.avaliacao_id = (res.data && res.data[0]) ? res.data[0].avaliacao_id : avaliacao && avaliacao.id ? avaliacao.id : null
                            this.selectedChat.avaliador_id = this.user ? this.user.id : null;
                            this.selectedChat.avaliador = this.user ? this.user : null;
                            this.selectedChat.send_avaliador = indexChat ? indexChat : null
                            this.selectedChat.avaliacao = avaliacao ? avaliacao : null
                            this.$validator.reset('mensagens');
                        }
                        $('#modalChatAvaliador').modal({backdrop: 'static', keyboard: false, show: true})
                        this.$bvModal.show('modalChatAvaliador')

                    })
                }
            },
            StatusAvaliador(registro){
                this.selectedAvaliador = registro
                $('#modalAvaliador').modal({backdrop: 'static', keyboard: false, show: true})
                this.$bvModal.show('modalAvaliador')
            },
            visualizarAnexo(registro){
                if(registro.regiao == 1){
                    window.open(this.baseUrl+'/pdf/submissao_regional_sul_2022/'+ registro.link_trabalho, '_blank');
                }
                if(registro.regiao == 2){
                    window.open(this.baseUrl+'/pdf/submissao_regional_nordeste_2022/'+ registro.link_trabalho, '_blank');
                }
                if(registro.regiao == 3){
                    window.open(this.baseUrl+'/pdf/submissao_regional_suldeste_2022/'+ registro.link_trabalho, '_blank');
                }
                if(registro.regiao == 4){
                    window.open(this.baseUrl+'/pdf/submissao_regional_centrooeste_2022/'+ registro.link_trabalho, '_blank');
                }
                if(registro.regiao == 5){
                    window.open(this.baseUrl+'/pdf/submissao_regional_norte_2022/'+ registro.link_trabalho, '_blank');
                }

            },
            find_dt(registro){
                if(registro && registro.dt){
                    let selectedDt =  this.divisoes_tematicas.find(dt => dt.id === registro.dt)
                    let dt = selectedDt ? selectedDt.dt : ''
                    let dt_descricao = selectedDt ? selectedDt.descricao : ''
                    let returno = dt+' - '+dt_descricao
                    return returno ? returno : "NI"
                }
            },
            find_avaliacoes(registro){
                if(registro){
                    if(registro.submissao_sudeste){
                        return registro.submissao = registro.submissao_sudeste
                    }

                    if(registro.submissao_sul){
                        return registro.submissao = registro.submissao_sul
                    }

                    if(registro.submissao_nordeste){
                        return registro.submissao = registro.submissao_nordeste
                    }

                    if(registro.submissao_norte){
                        return registro.submissao = registro.submissao_norte
                    }

                    if(registro.submissao_centro_oeste){
                        return registro.submissao = registro.submissao_centro_oeste
                    }
                }
            },
            showForm(registro) {
                this.selected = registro
                $('#form').modal({backdrop: 'static', keyboard: false, show: true})
                this.$bvModal.show('coordenadorModal')
            },
            showDelete(registro) {
                this.toDelete = registro
                this.$bvModal.show('deleteModal')
            },
            store($event) {
                this.registros.splice(0, 0, $event)
                this.$bvModal.hide('coordenadorModal')
                this.total++
            },
            update($event) {
                let index = this.registros.findIndex(registro => registro.id == this.selected.id)
                this.registros.splice(index, 1, $event)
                this.$bvModal.hide('coordenadorModal')
            },
            async destroy() {
                await axios.delete(`${process.env.MIX_BASE_URL}/${this.page}/${this.toDelete.id}`).then(res => {
                    if(res.status == 200) {
                        let index = this.registros.findIndex(registro => registro.id == this.toDelete.id)
                        this.registros.splice(index, 1)
                        this.total--
                        axios.get(this.url.concat(`&page=${this.currentPage}`)).then(res => {
                            const toFilter = [...this.registros, ...res.data.data]
                            const filtered = toFilter.reduce((items, current) => {
                                const x = items.find(item => item.id === current.id);
                                return !x ? items.concat([current]) : items
                            }, []);
                            this.registros = filtered
                            this.currentPage = res.data.current_page
                        })
                        this.$notify({
                            group: "submit",
                            title: "Sucesso!",
                            text: "registro removido.",
                            type: "success"
                        })
                    }
                }).catch(error => {
                    if(error.response.status == 422) {
                        if(error.response.data.message == "The given registro was invalid.") {
                            this.$notify({
                                group: "submit",
                                title: "Erro no cadastro",
                                text: "Campos obrigatórios não preenchidos.",
                                type: "error"
                            })
                        }
                    }
                    if(error.response.status == 403) {
                        if(error.response.data.message == "This action is unauthorized.") {
                            this.$notify({
                                group: "submit",
                                title: "Erro!",
                                text: "Ação não autorizada.",
                                type: "error"
                            })
                        }
                    }
                })
            },
            getDivisoesTematicas(){
                let urlgetDivisoesTematicas = this.baseUrl+"/get/divisoes-tematicas";

                $.ajax({
                    method: "GET",
                    url: urlgetDivisoesTematicas,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.divisoes_tematicas = res
                    },
                    error: (res) => {
                        console.log(res)
                        
                    }
                }); 
            },
        },
        async created() {
            await this.getLoggedUser().then(() => this.get())
            this.get = debounce(this.get, 500)

            this.getDivisoesTematicas()

        },
        mounted() {
            this.$refs['scroll'].addEventListener('scroll', debounce(this.handleScroll, 500))


        },
        destroyed () {
            this.$refs['scroll'].removeEventListener('scroll', this.handleScroll)
        },
    }
</script>
