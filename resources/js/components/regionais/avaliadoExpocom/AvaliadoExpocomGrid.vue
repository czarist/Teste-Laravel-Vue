<template>
    <div class="mt-4">
        <h5 class="col-12 d-flex justify-content-between">
            Todos os trabalhos enviados
        </h5>
        <div class="col-12">
            <div class="card">
                <div class="card-body pb-2">
                    <div v-if="loading">
                        <h5 class="d-flex justify-content-center">Carregando...</h5>
                        <b-progress :value="value" :max="max" ></b-progress>
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
                                            'bi-funnel' : sort!= 'id',
                                            'bi-sort-up-alt' : sort== 'id' && asc == true,
                                            'bi-sort-down-alt' : sort== 'id' && asc == false
                                        }"></i> Insc-Trab 
                                    </th>
                                    <th
                                        class="align-middle text-center"
                                        width="20%"
                                        @click="handleSort('titulo')">
                                        <i class="bi" :class="{
                                            'bi-funnel' : sort!= 'titulo',
                                            'bi-sort-up-alt' : sort== 'titulo' && asc == true,
                                            'bi-sort-down-alt' : sort== 'titulo' && asc == false
                                        }"></i> Titulo 
                                    </th>
                                    <th
                                        class="align-middle text-center"
                                        width="10%"
                                        @click="handleSort('status_coordenador')">
                                        <i class="bi" :class="{
                                            'bi-funnel' : sort!= 'status_coordenador',
                                            'bi-sort-up-alt' : sort== 'status_coordenador' && asc == true,
                                            'bi-sort-down-alt' : sort== 'status_coordenador' && asc == false
                                        }"></i> Status Coordenador 
                                    </th>
                                    <th class="align-middle text-center" width="5%">VER JUSTIFICATIVA</th>
                                    <th class="align-middle text-center" width="5%">PDF</th>
                                    <th class="align-middle text-center" width="5%">AÇÂO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(registro, index) in registros" :key="index">
                                    <td class="align-middle text-center" >{{ registro ? registro.id : "NI" }}</td>
                                    <td class="align-middle text-center" >{{ registro ? registro.desc_obj_estudo.substring(15, 0) : "NI" }}</td>
                                    <td class="align-middle text-center" >
                                        <div v-if="registro && registro.avaliacao">                                    
                                            {{ registro && registro.avaliacao ? registro.avaliacao.status_coordenador : "NI" }}
                                        </div>
                                        <div v-else>
                                            Sem Coordenador
                                        </div>

                                        </td>
                                    <td class="align-middle text-center" >
                                        <div 
                                            v-if="registro && registro.avaliacao && registro.avaliacao.justificativa_coordenador != null"
                                        >
                                            <button
                                                v-tooltip.bottom="{
                                                content: 'Ver Justificativa',
                                                delay: 0,
                                                class: 'tooltip-custom tooltip-arrow'
                                                }"
                                                title="Ver Justificativa"
                                                class="btn btn-primary"
                                                @click="visualizarJustificativa(registro)"
                                            >
                                            Justificativa
                                            </button>


                                        </div>
                                        <div v-else>
                                            Sem Justificativa
                                        </div>
                                    </td>

                                    <td class="align-middle text-center" >
                                        <div v-if="registro && registro.link_trabalho">
                                            <button
                                                v-tooltip.bottom="{
                                                content: 'Visualizar Anexo',
                                                delay: 0,
                                                class: 'tooltip-custom tooltip-arrow'
                                                }"
                                                title="Visualizar Anexo"
                                                class="btn btn-primary"
                                                @click="visualizarAnexo(registro)"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM1.6 11.85H0v3.999h.791v-1.342h.803c.287 0 .531-.057.732-.173.203-.117.358-.275.463-.474a1.42 1.42 0 0 0 .161-.677c0-.25-.053-.476-.158-.677a1.176 1.176 0 0 0-.46-.477c-.2-.12-.443-.179-.732-.179Zm.545 1.333a.795.795 0 0 1-.085.38.574.574 0 0 1-.238.241.794.794 0 0 1-.375.082H.788V12.48h.66c.218 0 .389.06.512.181.123.122.185.296.185.522Zm1.217-1.333v3.999h1.46c.401 0 .734-.08.998-.237a1.45 1.45 0 0 0 .595-.689c.13-.3.196-.662.196-1.084 0-.42-.065-.778-.196-1.075a1.426 1.426 0 0 0-.589-.68c-.264-.156-.599-.234-1.005-.234H3.362Zm.791.645h.563c.248 0 .45.05.609.152a.89.89 0 0 1 .354.454c.079.201.118.452.118.753a2.3 2.3 0 0 1-.068.592 1.14 1.14 0 0 1-.196.422.8.8 0 0 1-.334.252 1.298 1.298 0 0 1-.483.082h-.563v-2.707Zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638H7.896Z"/>
                                                </svg>   
                                            </button>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span
                                            v-if="
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador == 'Aceito'
                                            "
                                            v-tooltip.bottom="{
                                                content: 'Enviar video',
                                                delay: 0,
                                                class: 'tooltip-custom tooltip-arrow'
                                            }"
                                            :disabled="loading"
                                            title="Enviar video"
                                            class="btn btn-success btn-sm mr-1"
                                            @click="sendVideo(registro)"
                                        >
                                            Enviar Video
                                        </span>

                                        <a
                                            v-if="registro && registro.avaliacao && registro.avaliacao.status_coordenador == 'Aceito'"
                                            v-tooltip.bottom="{
                                                content: 'Carta de Aceite',
                                                delay: 0,
                                                class: 'tooltip-custom tooltip-arrow'
                                            }"
                                            :disabled="loading"
                                            title="Carta de Aceite"
                                            class="btn btn-info btn-sm mr-1 text-white"
                                            target="_blank"
                                            :href="`${baseUrl}/submissao-expocom/carta_aceite/pdf/${registro.regiao}/${registro.id}`"
                                        >
                                            Carta de Aceite
                                        </a>
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

        <ver-justificativa-modal :selectedJustificativa="selectedJustificativa"></ver-justificativa-modal>
        <enviar-video-modal :selectedVideo="selectedVideo" @save="save($event)"></enviar-video-modal>
        <notifications group="submit" position="center bottom" />
    </div>
</template>

<script>
    import debounce from 'debounce'
    import GridMixin from '../../mixins/grid-mixin'
    import VerJustificativaModal from './VerJustificativaModal.vue'
    import EnviarVideoModal from './EnviarVideoModal.vue'

    export default {
        mixins: [GridMixin],
        components: {
            VerJustificativaModal:() => import('./VerJustificativaModal.vue'),
            EnviarVideoModal:() => import('./EnviarVideoModal.vue'),
        },
        data() {
            return {
                value: 100,
                max: 100,
                page: 'submissao-expocom',
                baseUrl: process.env.MIX_BASE_URL,
                loading: true,
                selectedIndicar: null,
                selectedCoordenador: null,
                selectedJustificativa: null,
                scroll: false,
                mensagens: [],
                selectedChat: {
                    id: null,
                    avaliacao_id: null,
                    avaliador_id: null,
                    avaliador_id: null,
                    coordenador_id: null,
                    mensagem: null
                },
                selectedVideo: null,
                toDelete: null,
                divisoes_tematicas: [],
            }
        },
        methods: {
            async save(post) {  
                this.loading = true         
                await this.$validator.validateAll().then((valid) => {
                    if(valid) {                        
                            this.message('Salvando...' ,'Estamos salvando suas informações','info');

                        setTimeout(() => {

                            let formData = new FormData()
                            formData.append('post', JSON.stringify(this.selectedVideo));
                            formData.append('file', post.file)
                            formData.append('_method', 'post')

                            let urlSave = this.baseUrl+"/submissao-expocom/envio_video";

                            $.ajax({
                                method: "POST",
                                url: urlSave,
                                headers: {
                                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                                },
                                data: formData,
                                dataType: 'json',
                                contentType: false,
                                processData: false,
                                success: (res) => {
                                    if (res.message == "error") {
                                    } else {
                                        this.message(
                                            "Erro",
                                            "Erro ao tentar salvar seus dados, tente novamente dentro de alguns minutos ",
                                            "error"
                                            
                                        );
                                        this.loading = false;
                                    }
                                    this.message(
                                        "Sucesso",
                                        "Seus dados foram alterados com sucesso",
                                        "success",
                                        
                                    );
                                    this.loading = false;
                                    window.location.reload();
                                },
                                error: (error) => {
                                    console.log(error);
                                    if (error.status == 422) {
                                        if (error.response.message == "The given data was invalid.") {
                                            this.loading = false;
                                            return this.message(
                                                "Campos Obrigatórios",
                                                "Preencha todos os campos obrigatórios",
                                                "error"
                                            );
                                        }
                                    }
                                    if (error.status == 500) {
                                        this.loading = false;
                                        this.message(
                                            "Erro",
                                            "Erro ao tentar salvar seus dados, tente novamente dentro de alguns minutos ",
                                            "error",
                                            -1
                                        );
                                    }
                                    if (error.status == 403) {
                                        if (
                                            error.response.message == "This action is unauthorized."
                                        ) {
                                            this.loading = false;
                                            this.message("Erro", "Ação não autorizada.", "error");
                                        }
                                    }
                                    this.loading = false;
                                    this.message(
                                        "Erro",
                                        "Erro ao tentar salvar seus dados, tente novamente dentro de alguns minutos ",
                                        "error"                                    
                                    );
                                },
                            });
                        }, 1000);
                        
                    } else {
                        this.loading = false
                        this.message('Campos Obrigatórios', 'Preencha todos os campos obrigatórios', 'error');
                    }
                })
            },
            sendVideo(registro) {
                this.selectedVideo = registro
                $('#modalVideo').modal({backdrop: 'static', keyboard: false, show: true})
                this.$bvModal.show('modalVideo')

            },
            calc_media(registro) {
                if (registro && registro.avaliacao) {
                    registro.avaliacao.media_final = (registro.avaliacao.media_1 + registro.avaliacao.media_2 + registro.avaliacao.media_3) / 3

                    return registro.avaliacao.media_final.toString().substring(3, 0)
                }
                return "Sem média geral"
            },
            EditTrabalho(regiao, tipo){
                
                var regiaoName = (regiao == 1) ? 'sul' : (regiao == 2) ? 'nordeste' : (regiao == 3) ? 'suldeste' : (regiao == 4) ? 'centrooeste' : 'norte' 

                if(tipo == 'Divisões Temáticas'){
                    window.location.href = this.baseUrl + `/submissao/regional/${regiaoName}`
                }
                if(tipo == 'Mesa'){
                    window.location.href = this.baseUrl + `/submissaomesa/regional/${regiaoName}`
                }
                if(tipo == 'Intercom Júnior'){
                    window.location.href = this.baseUrl + `/submissao/regional/${regiaoName}`
                }

            },
            resetModalChat() {
                this.selectedChat.id = null,
                this.selectedChat.avaliacao_id = null,
                this.selectedChat.avaliado_id = null,
                this.selectedChat.mensagem = null
            },
            async getChat(id) {
                if(id){
                    await axios.get(`${this.baseUrl}/coordenador/get/chat/${id}`)
                    .then(res =>{
                        if(res.data.length > 0){
                            this.mensagens = res.data ;
                            this.selectedChat.avaliacao_id = res.data && res.data[0] ? res.data[0].avaliacao_id : null;
                            this.selectedChat.avaliado_id = this.user ? this.user.id : null;
                            this.selectedChat.avaliado = this.user ? this.user : null;
                            this.selectedChat.mensagem = null;
                            this.$validator.reset('mensagens');
                        } else{
                            this.mensagens = [];
                            this.selectedChat.id = id;
                        }
                        $('#modalChat').modal({backdrop: 'static', keyboard: false, show: true})
                        this.$bvModal.show('modalChat')

                    })
                }
            },
            visualizarAnexo(registro){
                if(registro.regiao == 1){
                    window.open(this.baseUrl+'/pdf/submissao_expocom_regional_sul_2022/'+ registro.link_trabalho, '_blank');
                }
                if(registro.regiao == 2){
                    window.open(this.baseUrl+'/pdf/submissao_expocom_regional_nordeste_2022/'+ registro.link_trabalho, '_blank');
                }
                if(registro.regiao == 3){
                    window.open(this.baseUrl+'/pdf/submissao_expocom_regional_suldeste_2022/'+ registro.link_trabalho, '_blank');
                }
                if(registro.regiao == 4){ 
                    window.open(this.baseUrl+'/pdf/submissao_expocom_regional_centrooeste_2022/'+ registro.link_trabalho, '_blank');
                }
                if(registro.regiao == 5){
                    window.open(this.baseUrl+'/pdf/submissao_expocom_regional_norte_2022/'+ registro.link_trabalho, '_blank');
                }

            },
            visualizarJustificativa(registro){
                if(registro){
                    this.selectedJustificativa = null;
                    this.selectedJustificativa = registro;
                    $('#modalVerJustificativa').modal({backdrop: 'static', keyboard: false, show: true})
                    this.$bvModal.show('modalVerJustificativa')

                }

            },
            find_dt(registro){
                if(registro && registro.dt){
                    let selectedDt =  this.divisoes_tematicas.find(dt => dt.id === registro.dt)
                    return selectedDt ? selectedDt.descricao : "NI"
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
