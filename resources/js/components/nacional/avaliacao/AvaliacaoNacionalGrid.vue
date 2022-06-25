<template>
    <div class="mt-4">
        <h5 class="col-12 d-flex justify-content-between">
            Área do Coordenador - Avaliação de Trabalho Intercom Júnior - Nacional
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

                        <div class="input-group input-group-sm col-6 col-sm-6 col-md-6 col-lg-6 mb-1">
                            <div class="input-group-prepend mb-3">
                                <span class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                </span>
                            </div>

                            <input type="search"
                                placeholder="Procurar..." 
                                class="form-control form-control-filter"
                                v-model="search" 
                                @change="get()"
                            >

                            <div class="input-group-append">
                                <button
                                    class="btn btn-primary dropdown-toggle mb-3"
                                    type="button"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                >{{ searchType.text }} 
                                <i class="bi bi-caret-down-fill"></i>                            
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" @click="searchType = { link: 'titulo', text: 'Título' }">Título</a>
                                </div>
                            </div>
                        </div>

                    </div>
                                          
                    <div class="table-responsive scroll" ref="scroll" v-show="!loading && registros.length > 0">
                        <table class="table table-sm table-striped table-hover table-bordered" v-if="user">
                            <thead>
                                <tr>
                                    <th
                                        class="align-middle text-center"
                                        style="font-size: 9px !important;"
                                        width="5%"
                                        @click="handleSort('id')">Insc-Trab 
                                    </th>
                                    <th
                                        class="align-middle text-center"
                                        width="20%"
                                        style="font-size: 9px !important;"                                        
                                        @click="handleSort('titulo')"> Titulo 
                                    </th>
                                    <th
                                        class="align-middle text-center"
                                        width="5%"
                                        style="font-size: 9px !important;"
                                        @click="handleSort('dt')">Categoria 
                                    </th>

                                    <th class="align-middle text-center" width="10%" style="font-size: 9px !important;">Avaliador  </th>
                                    <th
                                        class="align-middle text-center"
                                        width="5%"
                                        style="font-size: 9px !important;"
                                        @click="handleSort('status_avaliador')">Status Avaliador 
                                    </th>
                                    <th
                                        class="align-middle text-center"
                                        width="5%"
                                        style="font-size: 9px !important;"
                                        @click="handleSort('status_coordenador')"> Status Coordenador 
                                    </th>
                                    <th class="align-middle text-center" width="3%" style="font-size: 9px !important;">PDF</th>
                                    <th class="align-middle text-center" width="5%" style="font-size: 9px !important;">CHAT AUTOR</th>
                                    <th class="align-middle text-center" width="5%" style="font-size: 9px !important;">CHAT AVALIADOR</th>
                                    <th class="align-middle text-center" width="5%" style="font-size: 9px !important;">AÇÂO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(registro, index) in registros" :key="index">
                                    <td class="align-middle text-center " style="font-size: 11px !important;" >{{ registro ? registro.id : "NI" }}</td>
                                    <td class="align-middle text-center " style="font-size: 11px !important;">{{ registro ? registro.titulo : "NI" }}</td>
                                    <td class="align-middle text-center " style="font-size: 11px !important;">{{ find_dt(registro) }}</td>
                                    <td class="align-middle text-center " style="font-size: 11px !important;">
                                        <div v-if="registro && registro.avaliacao">                       

                                            {{  registro && registro.avaliacao && registro.avaliacao.avaliador_1_obj ? registro.avaliacao.avaliador_1_obj.name : "NI" }}<br>
                                            {{ registro && registro.avaliacao && registro.avaliacao.avaliador_2_obj ? registro.avaliacao.avaliador_2_obj.name : "NI" }}<br>
                                            {{ registro && registro.avaliacao && registro.avaliacao.avaliador_3_obj ? registro.avaliacao.avaliador_3_obj.name : "NI" }}
                                        </div>
                                    </td>
                                    <td class="align-middle text-center" style="font-size: 11px !important;">
                                        <div>                                    
                                            {{ registro && registro.avaliacao ? registro.avaliacao.status_avaliador_1 : "NI" }}<br>
                                            {{ registro && registro.avaliacao ? registro.avaliacao.status_avaliador_2 : "NI" }}<br>
                                            {{ registro && registro.avaliacao ? registro.avaliacao.status_avaliador_3 : "NI" }}<br>
                                        </div>    


                                    </td>
                                    <td class="align-middle text-center" style="font-size: 11px !important;">{{ registro && registro.avaliacao ? registro.avaliacao.status_coordenador : "NI" }}</td>
                                    <td class="align-middle text-center" >
                                        <div v-if="registro && registro.link_trabalho">
                                                <svg 
                                                    v-tooltip.bottom="{
                                                    content: 'Visualizar PDF',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Visualizar PDF"
                                                    @click="visualizarAnexo(registro)"
                                                    style="font-size:50px;"

                                                id="Capa_1" enable-background="new 0 0 791.454 791.454" height="40" viewBox="0 0 791.454 791.454" width="40" xmlns="http://www.w3.org/2000/svg"><g><g id="Vrstva_x0020_1_15_"><path clip-rule="evenodd" d="m202.808 0h264.609l224.265 233.758v454.661c0 56.956-46.079 103.035-102.838 103.035h-386.036c-56.956 0-103.035-46.079-103.035-103.035v-585.384c-.001-56.956 46.078-103.035 103.035-103.035z" fill="#e5252a" fill-rule="evenodd"/><g fill="#fff"><path clip-rule="evenodd" d="m467.219 0v231.978h224.463z" fill-rule="evenodd" opacity=".302"/><path d="m214.278 590.525v-144.566h61.505c15.228 0 27.292 4.153 36.389 12.657 9.097 8.306 13.646 19.579 13.646 33.62s-4.549 25.314-13.646 33.62c-9.097 8.504-21.161 12.657-36.389 12.657h-24.523v52.012zm36.982-83.456h20.37c5.537 0 9.888-1.187 12.855-3.955 2.966-2.571 4.549-6.131 4.549-10.877s-1.582-8.306-4.549-10.877c-2.966-2.769-7.317-3.955-12.855-3.955h-20.37zm89.785 83.456v-144.566h51.221c10.086 0 19.579 1.384 28.478 4.351 8.899 2.966 17.008 7.12 24.127 12.855 7.12 5.537 12.855 13.052 17.008 22.545 3.955 9.493 6.131 20.37 6.131 32.631 0 12.064-2.175 22.941-6.131 32.433-4.153 9.493-9.888 17.008-17.008 22.545-7.12 5.735-15.228 9.888-24.127 12.855-8.899 2.966-18.392 4.351-28.478 4.351zm36.191-31.444h10.679c5.735 0 11.075-.593 16.019-1.978 4.746-1.384 9.295-3.56 13.646-6.526 4.153-2.966 7.515-7.12 9.888-12.657s3.56-12.064 3.56-19.579c0-7.713-1.187-14.239-3.56-19.776s-5.735-9.69-9.888-12.657c-4.351-2.966-8.899-5.142-13.646-6.526-4.944-1.384-10.284-1.978-16.019-1.978h-10.679zm109.364 31.444v-144.566h102.838v31.445h-65.856v23.138h52.605v31.247h-52.605v58.736z"/></g></g></g></svg>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center" >
                                        <button
                                            v-if="
                                                registro && registro.avaliacao &&
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador != 'Aceito' &&
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador != 'Recusado' ||
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador == 'Em Análise' ||
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador == 'Em avaliação' ||
                                                registro && registro.avaliacao && !registro.avaliacao.status_coordenador
                                            "
                                            v-tooltip.bottom="{
                                                content: 'MENSAGEM P/ AUTOR',
                                                delay: 0,
                                                class: 'tooltip-custom tooltip-arrow'
                                            }"
                                            @click="resetModalChat(),getChat(registro.avaliacao.id)"
                                            type="button"
                                            class="btn btn-sm btn-primary p-1 m-0"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
                                                <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                                <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9.06 9.06 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.437 10.437 0 0 1-.524 2.318l-.003.011a10.722 10.722 0 0 1-.244.637c-.079.186.074.394.273.362a21.673 21.673 0 0 0 .693-.125zm.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6c0 3.193-3.004 6-7 6a8.06 8.06 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a10.97 10.97 0 0 0 .398-2z"/>
                                            </svg><br>
                                            <span style="font-size: 9px !important;">AUTOR</span>
                                        </button>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button
                                            v-if="
                                                registro && registro.avaliacao &&
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador != 'Aceito' &&
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador != 'Recusado' ||
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador == 'Em Análise' ||
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador == 'Em avaliação' ||
                                                registro && registro.avaliacao && !registro.avaliacao.status_coordenador
                                            "
                                            v-tooltip.bottom="{
                                                content: 'MENSAGEM PARA O AVALIADOR',
                                                delay: 0,
                                                class: 'tooltip-custom tooltip-arrow'
                                            }"
                                            @click="resetModalChooseChat(),chooseChatAvaliador(registro.avaliacao)"
                                            type="button"
                                            class="btn btn-sm btn-primary p-1 m-0"
                                        >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-dots" viewBox="0 0 16 16">
                                            <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                            <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                        </svg><br>
                                            <span style="font-size: 9px !important;">AVALIADOR</span>                                        
                                        </button>
                                    </td>
                                    <td class="align-middle text-center" style="font-size: 11px !important;">
                                        <span
                                            v-if="
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador != 'Aceito' &&
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador != 'Recusado' ||
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador == 'Em Análise' ||
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador == 'Em avaliação' ||
                                                registro && registro.avaliacao && !registro.avaliacao.status_coordenador ||
                                                registro && !registro.avaliacao
                                            "
                                        >
                                            <a href="#" class="botaoazul p-1 m-1"
                                                v-tooltip.bottom="{
                                                content: 'Indicar Avaliadores',
                                                delay: 0,
                                                class: 'tooltip-custom tooltip-arrow'
                                                }"
                                                title="Indicar Avaliadores"
                                                @click="Indicar(registro)"
                                            >Indicar Avaliadores                                                                                        
                                            </a>

                                            <a href="#" class="botaoazul p-1 m-1"
                                                v-if="registro && registro.avaliacao"
                                                v-tooltip.bottom="{
                                                content: 'Status Coordenador',
                                                delay: 0,
                                                class: 'tooltip-custom tooltip-arrow'
                                                }"
                                                title="Status Coordenador"
                                                @click="StatusCoordenador(registro)"
                                            >Status Coordenador                                                                                        
                                            </a>

                                            <a href="#" class="botaoazul p-1 m-1"
                                                v-if="registro && registro.avaliacao"
                                                v-tooltip.bottom="{
                                                content: 'Habilitar Edição do Trabalho',
                                                delay: 0,
                                                class: 'tooltip-custom tooltip-arrow'
                                                }"
                                                :title="registro && registro.avaliacao && !registro.avaliacao.edit ? `Habilitar Edição do Trabalho` : `Desabilitar Edição do Trabalho`"
                                                :class="registro && registro.avaliacao && !registro.avaliacao.edit ? `btn btn-danger btn-sm mr-1` : `btn btn-success btn-sm mr-1`"
                                                @click="EditTrabalho(registro, index)"
                                            >
                                                {{ registro && registro.avaliacao && !registro.avaliacao.edit ? "Edição de trabalho desabilitada" : "Edição de trabalho habilitada"}}                                            
                                            </a>
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

        <indicar-modal :selectedIndicar="selectedIndicar"></indicar-modal>
        <status-coordenador-modal :selectedCoordenador="selectedCoordenador" :coordenador="coordenador"></status-coordenador-modal>
        <chat-modal :selectedChat="selectedChat" :user="user" :mensagens="mensagens" :scroll.sync="scroll"></chat-modal>
        <escolha-chat-modal :chooseChat="chooseChat" :user="user"></escolha-chat-modal>
        <notifications group="submit" position="center bottom" />
    </div>
</template>

<script>
    import debounce from 'debounce'
    import GridMixin from '../../mixins/grid-mixin'
    import IndicarModal from './IndicarModal.vue'
    import StatusCoordenadorModal from './StatusCoordenadorModal.vue'
    import ChatModal from './ChatModal.vue'
    import EscolhaChatModal from './EscolhaChatModal.vue'

    export default {
        mixins: [GridMixin],
        components: {
            IndicarModal:() => import('./IndicarModal.vue'),
            StatusCoordenadorModal:() => import('./StatusCoordenadorModal.vue'),
            ChatModal:() => import('./ChatModal.vue'),
            EscolhaChatModal:() => import('./EscolhaChatModal.vue')
        },
        data() {
            return {
                value: 100,
                max: 100,
                page: 'avaliacao_nacional',
                baseUrl: process.env.MIX_BASE_URL,
                loading: true,
                selectedIndicar: null,
                selectedCoordenador: null,
                scroll: false,
                mensagens: [],
                coordenador: null,
                selectedChat: {
                    id: null,
                    avaliacao_id: null,
                    avaliador_id: null,
                    avaliado_id: null,
                    coordenador_id: null,
                    send_avaliador: null,
                    mensagem: null
                },
                chooseChat:{
                    avaliacao: null,
                    coordenador_id: null,
                    coordenador: null,
                },
                toDelete: null,
                divisoes_tematicas: [],
                divisoes_tematicas_jr: [],
                modalidade: {
                    modalidade_search : null,
                },
                statusAvaliador: [
                    { id: "Em Análise" , descricao: "Em Análise"},
                    { id: "Alteração Solicitada" , descricao: "Alteração Solicitada"},
                    { id: "Avaliado" , descricao: "Avaliado"},
                ],
                statusCoordenador: [
                    { id: "Em Análise" , descricao: "Em Análise"},
                    { id: "Alteração Solicitada" , descricao: "Alteração Solicitada"},
                    { id: "Avaliado" , descricao: "Avaliado"},
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
            EditTrabalho(registro, index){
                axios.post(this.baseUrl + '/submissao/edit', {
                    id: registro.avaliacao.id,
                    edit: registro.avaliacao.edit == 1 ? 0 : 1
                }).then(response => {
                    console.log(response)
                    if(response && response.data && response.data.success == true){
                        this.registros[index].avaliacao.edit = response.data[0].edit
                    }
                }).catch(error => {
                    console.log(error)
                })
            },
            resetModalChat() {
                this.selectedChat.id = null,
                this.selectedChat.avaliacao_id = null,
                this.selectedChat.coordenador_id = null,
                this.selectedChat.coordenador = null,
                this.selectedChat.send_avaliador = null,
                this.selectedChat.mensagem = null,
                this.selectedChat.avaliado_id = null,
                this.selectedChat.avaliador_id = null
            },
            async getChat(id) {
                if(id){
                    await axios.get(`${this.baseUrl}/coordenador/get/chat/${id}`)
                    .then(res =>{
                        if(res.data.length > 0){
                            this.mensagens = res.data ;
                            this.selectedChat.avaliacao_id = res.data && res.data[0] ? res.data[0].avaliacao_id : null;
                            this.selectedChat.coordenador_id = this.coordenador && this.coordenador.id ? this.coordenador.id : null
                            this.selectedChat.coordenador = this.coordenador && this.coordenador ? this.coordenador : null
                            this.selectedChat.mensagem = null;
                            this.$validator.reset('mensagens');
                        } else{
                            this.mensagens = [];
                            this.selectedChat.id = id;
                            this.selectedChat.avaliacao_id = (res.data && res.data[0]) ? res.data[0].avaliacao_id : id ? id : null;
                            this.selectedChat.coordenador_id = this.coordenador && this.coordenador.id ? this.coordenador.id : null
                            this.selectedChat.coordenador = this.coordenador && this.coordenador ? this.coordenador : null
                            this.$validator.reset('mensagens');
                        }
                        $('#modalChat').modal({backdrop: 'static', keyboard: false, show: true})
                        this.$bvModal.show('modalChat')
                    })
                }
            },
            resetModalChooseChat() {
                this.chooseChat.avaliacao = null
                this.chooseChat.coordenador_id = null,
                this.chooseChat.coordenador = null
            },
            async chooseChatAvaliador(avaliacao) {
                if(avaliacao && avaliacao.id){

                    this.chooseChat.avaliacao = avaliacao
                    this.chooseChat.coordenador_id = this.coordenador && this.coordenador.id ? this.coordenador.id : null
                    this.chooseChat.coordenador = this.coordenador && this.coordenador ? this.coordenador : null

                    $('#modalEscolhaChat').modal({backdrop: 'static', keyboard: false, show: true})
                    this.$bvModal.show('modalEscolhaChat')
                }
            },
            Indicar(registro){
                this.selectedIndicar = registro
                $('#modalIndicar').modal({backdrop: 'static', keyboard: false, show: true})
                this.$bvModal.show('modalIndicar')
            },
            StatusCoordenador(registro){
                this.selectedCoordenador = registro
                $('#modalCoordenador').modal({backdrop: 'static', keyboard: false, show: true})
                this.$bvModal.show('modalCoordenador')
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

                    if(registro && registro.tipo == "Mesa" || registro.tipo == "Divisões Temáticas"){
                        let selectedDt =  this.divisoes_tematicas.find(dt => dt.id === registro.dt)
                        let dt = selectedDt ? selectedDt.dt : ''
                        let dt_descricao = selectedDt ? selectedDt.descricao : ''
                        let returno = dt
                        return returno ? returno : "NI"

                    }

                    if(registro && registro.tipo == "Intercom Júnior"){
                        let selectedDt =  this.divisoes_tematicas_jr.find(dt => dt.id === registro.dt)
                        let dt = selectedDt ? selectedDt.dt : ''
                        let dt_descricao = selectedDt ? selectedDt.descricao : ''
                        let returno = dt
                        return returno ? returno : "NI"
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
            getDivisoesTematicasJr(){
                let urlgetDivisoesTematicas = this.baseUrl+"/get/divisoes-tematicas-jr";

                $.ajax({
                    method: "GET",
                    url: urlgetDivisoesTematicas,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.divisoes_tematicas_jr = res
                    },
                    error: (res) => {
                        console.log(res)
                        
                    }
                }); 
            },
            getCoordenador(){
                let urlgetCoordenador = this.baseUrl+"/get/coordenador/"+this.user.id;

                $.ajax({
                    method: "GET",
                    url: urlgetCoordenador,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.coordenador = res
                    },
                    error: (res) => {
                        console.log(res)
                        
                    }
                }); 
            }
        },
        async created() {
            await this.getLoggedUser().then(() => this.get())
            this.get = debounce(this.get, 500)

            this.getDivisoesTematicas(),
            this.getDivisoesTematicasJr(),            
            this.getCoordenador()

        },
        mounted() {
            this.$refs['scroll'].addEventListener('scroll', debounce(this.handleScroll, 500))
        },
        destroyed () {
            this.$refs['scroll'].removeEventListener('scroll', this.handleScroll)
        },
    }
</script>
