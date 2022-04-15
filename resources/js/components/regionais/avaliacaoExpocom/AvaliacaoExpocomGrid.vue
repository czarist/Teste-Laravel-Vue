<template>
    <div class="mt-4">
        <h5 class="col-12 d-flex justify-content-between">
            Área do Coordenador - Distribuição de Trabalho Expocom - {{ regiao_nome ? regiao_nome : '' }}
        </h5>
        <div class="col-12">
            <div class="card">
                <div class="card-body pb-2">
                    <div v-if="loading">
                        <h5 class="d-flex justify-content-center">Carregando...</h5>
                        <b-progress :value="value" :max="max" ></b-progress>
                    </div>
                                          
                    <div class="row d-flex align-items-center mb-3" v-if="!loading">
                        <label class="invalid-feedback font-weight-bold">* Clique em "Buscar Categoria" para filtra os trabalhos para Expocom </label>
                        <div class="input-group input-group-sm col-6 col-sm-6 col-md-6 col-lg-6 mb-1">
                            <div class="input-group-prepend mb-3">
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
                                :options="categorias"
                                :reduce="categoria => categoria.descricao"
                                v-model="categoria.categoria_search"
                                label="descricao"
                                @input="getModalidade()"
                                placeholder="Buscar Categoria..."
                            >
                                <template #selected-option="{ descricao }">
                                    <em>{{ descricao }}</em>
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

                            <v-select
                                class="flex-fill"
                                :name="`modalidade`"
                                :disabled="loading"
                                :options="modalidades"
                                :reduce="modalidade => modalidade.descricao"
                                v-model="modalidade.modalidade_search"
                                label="descricao"
                                @input="get()"
                                placeholder="Buscar Modalidade..."
                            >
                                <template #selected-option="{ descricao }">
                                    <em>{{ descricao }}</em>
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
                                        @click="handleSort('id')"
                                        style="font-size: 9px !important;">
                                        Insc-Trab 
                                        
                                    </th>
                                    <th
                                        class="align-middle text-center"
                                        width="20%"
                                        style="font-size: 9px !important;"
                                    >
                                        Titulo 
                                    </th>
                                    <th
                                        class="align-middle text-center"
                                        width="10%"
                                        style="font-size: 9px !important;"
                                    >
                                        Categoria 
                                    </th>

                                    <th class="align-middle text-center" width="10%" >Avaliador  </th>
                                    <th
                                        class="align-middle text-center"
                                        width="10%"
                                        style="font-size: 9px !important;"
                                    >
                                        Status Avaliador 
                                    </th>
                                    <th
                                        class="align-middle text-center"
                                        width="10%"
                                        style="font-size: 9px !important;"
                                        >
                                        Status Coordenador 
                                    </th>
                                    <th
                                        class="align-middle text-center"
                                        width="10%"
                                        style="font-size: 9px !important;"
                                        @click="sorts('media_final')">
                                        <i class="bi" :class="{
                                            'bi-funnel' : currentSort != 'media_final',
                                            'bi-sort-up-alt' : currentSort == 'media_final' && currentSortDir == 'asc',
                                            'bi-sort-down-alt' : currentSort == 'media_final' && currentSortDir =='desc'
                                        }"></i>
                                        Média Geral
                                    </th>
                                    <th class="align-middle text-center" width="3%" style="font-size: 9px !important;">PDF</th>
                                    <th class="align-middle text-center" width="5%" style="font-size: 9px !important;">CHAT AVALIADOR</th>
                                    <th class="align-middle text-center" width="5%" style="font-size: 9px !important;">AÇÂO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(registro, index) in sortedRegistros" :key="index">
                                    <td class="align-middle text-center" >{{ registro ? registro.id : "NI" }} - {{ registro && registro.inscricao ? registro.inscricao.id : "NI" }}</td>
                                    <td class="align-middle text-center" >
                                            <button 
                                                type="button" 
                                                class="btn btn-outline-info btn-sm"
                                                @click="viewSub(registro)"
                                            >
                                                {{ registro && registro.inscricao && registro.inscricao.user && registro.inscricao.user.indicacao ? registro.inscricao.user.indicacao.titulo_trabalho.substring(50, 0) : "NI" }}
                                            </button>

                                    </td>
                                    <td class="align-middle text-center">{{ registro && registro.inscricao && registro.inscricao.user &&  registro.inscricao.user.indicacao ? registro.inscricao.user.indicacao.modalidade.substring(6, 0) : "NI" }}</td>
                                    <td class="align-middle text-center" >
                                        <div v-if="registro && registro.avaliacao">
                                            {{  registro && registro.avaliacao && registro.avaliacao.avaliador_1_obj ? registro.avaliacao.avaliador_1_obj.name : "NI" }}<br>
                                            {{ registro && registro.avaliacao && registro.avaliacao.avaliador_2_obj ? registro.avaliacao.avaliador_2_obj.name : "NI" }}<br>
                                            {{ registro && registro.avaliacao && registro.avaliacao.avaliador_3_obj ? registro.avaliacao.avaliador_3_obj.name : "NI" }}
                                        </div>
                                        <div v-else>Sem Avaliadores</div>
                                    </td>
                                    <td class="align-middle text-center" >
                                        <div>                                    
                                            {{ registro && registro.avaliacao ? registro.avaliacao.status_avaliador_1 : "NI" }}<br>
                                            {{ registro && registro.avaliacao ? registro.avaliacao.status_avaliador_2 : "NI" }}<br>
                                            {{ registro && registro.avaliacao ? registro.avaliacao.status_avaliador_3 : "NI" }}<br>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center" >{{ registro && registro.avaliacao ? registro.avaliacao.status_coordenador : "NI" }}</td>
                                    <td class="align-middle text-center">
                                        <div>            
                                            {{ calc_media(registro, index) }}                        
                                        </div>    
                                    </td>
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
                                    <td class="align-middle text-center">
                                        <button
                                            v-if="
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador != 'Aceito' &&
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador != 'Recusado' && registro && registro.avaliacao && registro.avaliacao.avaliador_1 != null ||
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador == 'Em Análise' && registro && registro.avaliacao && registro.avaliacao.avaliador_1 != null ||
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador == 'Em avaliação' && registro && registro.avaliacao && registro.avaliacao.avaliador_1 != null ||
                                                registro && registro.avaliacao && !registro.avaliacao.status_coordenador &&
                                                registro && registro.avaliacao && registro.avaliacao.avaliador_1 != null
                                            "
                                            v-tooltip.bottom="{
                                                content: 'MENSAGEM P/ AVALIADOR',
                                                delay: 0,
                                                class: 'tooltip-custom tooltip-arrow'
                                            }"
                                            @click="resetModalChat(),getChat(registro.avaliacao, 1)"
                                            type="button"
                                            class="btn btn-sm btn-primary p-1 m-1"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
                                                <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                                <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9.06 9.06 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.437 10.437 0 0 1-.524 2.318l-.003.011a10.722 10.722 0 0 1-.244.637c-.079.186.074.394.273.362a21.673 21.673 0 0 0 .693-.125zm.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6c0 3.193-3.004 6-7 6a8.06 8.06 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a10.97 10.97 0 0 0 .398-2z"/>
                                            </svg><br>
                                            <span style="font-size: 9px !important;">AVALIADOR 1</span>
                                        </button>

                                        <button
                                            v-if="
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador != 'Aceito' &&
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador != 'Recusado' && registro && registro.avaliacao && registro.avaliacao.avaliador_2 != null ||
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador == 'Em Análise' && registro && registro.avaliacao && registro.avaliacao.avaliador_2 != null ||
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador == 'Em avaliação' && registro && registro.avaliacao && registro.avaliacao.avaliador_2 != null ||
                                                registro && registro.avaliacao && !registro.avaliacao.status_coordenador &&
                                                registro && registro.avaliacao && registro.avaliacao.avaliador_2 != null
                                            "
                                            v-tooltip.bottom="{
                                                content: 'MENSAGEM P/ AVALIADOR',
                                                delay: 0,
                                                class: 'tooltip-custom tooltip-arrow'
                                            }"
                                            @click="resetModalChat(),getChat(registro.avaliacao, 2)"
                                            type="button"
                                            class="btn btn-sm btn-primary p-1 m-1"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
                                                <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                                <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9.06 9.06 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.437 10.437 0 0 1-.524 2.318l-.003.011a10.722 10.722 0 0 1-.244.637c-.079.186.074.394.273.362a21.673 21.673 0 0 0 .693-.125zm.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6c0 3.193-3.004 6-7 6a8.06 8.06 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a10.97 10.97 0 0 0 .398-2z"/>
                                            </svg><br>
                                            <span style="font-size: 9px !important;">AVALIADOR 2</span>
                                        </button>

                                        <button
                                            v-if="
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador != 'Aceito' &&
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador != 'Recusado' && registro && registro.avaliacao && registro.avaliacao.avaliador_3 != null ||
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador == 'Em Análise' && registro && registro.avaliacao && registro.avaliacao.avaliador_3 != null ||
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador == 'Em avaliação' && registro && registro.avaliacao && registro.avaliacao.avaliador_3 != null ||
                                                registro && registro.avaliacao && !registro.avaliacao.status_coordenador &&
                                                registro && registro.avaliacao && registro.avaliacao.avaliador_3 != null
                                            "
                                            v-tooltip.bottom="{
                                                content: 'MENSAGEM P/ AVALIADOR',
                                                delay: 0,
                                                class: 'tooltip-custom tooltip-arrow'
                                            }"
                                            @click="resetModalChat(),getChat(registro.avaliacao, 3)"
                                            type="button"
                                            class="btn btn-sm btn-primary p-1 m-1"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
                                                <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                                <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9.06 9.06 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.437 10.437 0 0 1-.524 2.318l-.003.011a10.722 10.722 0 0 1-.244.637c-.079.186.074.394.273.362a21.673 21.673 0 0 0 .693-.125zm.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6c0 3.193-3.004 6-7 6a8.06 8.06 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a10.97 10.97 0 0 0 .398-2z"/>
                                            </svg><br>
                                            <span style="font-size: 9px !important;">AVALIADOR 3</span>
                                        </button>

                                    </td>
                                    <td class="align-middle text-center">
                                        <span
                                            v-if="
                                                registro && !registro.avaliacao ||        
                                                registro && registro.avaliacao && !registro.avaliacao.status_coordenador ||
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador != 'Aceito' &&
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador != 'Recusado' ||
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador == 'Em Análise' ||
                                                registro && registro.avaliacao && registro.avaliacao.status_coordenador && registro.avaliacao.status_coordenador == 'Em avaliação' 
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

        <indicar-expocom-modal :selectedIndicar="selectedIndicar"></indicar-expocom-modal>
        <status-coordenador-expocom-modal :selectedCoordenador="selectedCoordenador"></status-coordenador-expocom-modal>
        <chat-modal :selectedChat="selectedChat" :user="user" :mensagens="mensagens" :scroll.sync="scroll"></chat-modal>
        <chat2-modal :selectedChat="selectedChat" :user="user" :mensagens="mensagens" :scroll.sync="scroll"></chat2-modal>
        <chat3-modal :selectedChat="selectedChat" :user="user" :mensagens="mensagens" :scroll.sync="scroll"></chat3-modal>
        <visualizar-submissao-modal :selectedSub="selectedSub"></visualizar-submissao-modal>

        <notifications group="submit" position="center bottom" />
    </div>
</template>

<script>
    import debounce from 'debounce'
    import GridMixin from '../../mixins/grid-mixin'
    import IndicarExpocomModal from './IndicarExpocomModal.vue'
    import StatusCoordenadorExpocomModal from './StatusCoordenadorExpocomModal.vue'
    import ChatModal from './ChatModal.vue'
    import Chat2Modal from './Chat2Modal.vue'
    import Chat3Modal from './Chat3Modal.vue'
    import VisualizarSubmissaoModal from './VisualizarSubmissaoModal.vue'

    export default {
        props: ['regiao'],
        mixins: [GridMixin],
        components: {
            IndicarExpocomModal:() => import('./IndicarExpocomModal.vue'),
            StatusCoordenadorExpocomModal:() => import('./StatusCoordenadorExpocomModal.vue'),
            ChatModal:() => import('./ChatModal.vue'),
            Chat2Modal:() => import('./Chat2Modal.vue'),
            Chat3Modal:() => import('./Chat3Modal.vue'),
            VisualizarSubmissaoModal:() => import('./VisualizarSubmissaoModal.vue')
        },
        data() {
            return {
                value: 100,
                max: 100,
                page: 'avaliacaoexpocom',
                baseUrl: process.env.MIX_BASE_URL,
                loading: true,
                currentSort:'media_final',
                currentSortDir:'asc',
                selectedIndicar: null,
                selectedCoordenador: null,
                scroll: false,
                mensagens: [],
                categorias: [
                    { descricao: 'Cinema e Audiovisual', value: 'Cinema e Audiovisual'},
                    { descricao: 'Jornalismo', value: 'Jornalismo'},
                    { descricao: 'Produção Transdisciplinar', value: 'Produção Transdisciplinar'},
                    { descricao: 'Publicidade e Propaganda', value: 'Publicidade e Propaganda'},
                    { descricao: 'Rádio, TV e Internet', value: 'Rádio, TV e Internet'},
                    { descricao: 'Relações Públicas', value: 'Relações Públicas'}
                ],
                modalidades: [],
                categoria:{
                    categoria_search: null,
                },
                modalidade: {
                    modalidade_search: null
                },
                radio_internet: null,
                cinema_audiovisual: null,
                jornalismo: null,
                publicidade_propaganda: null,
                relacoes_publicas: null,
                producao_editorial: null,
                regiao_nome: '',
                coordenador: null,
                selectedSub: null,
                selectedChat: {
                    id: null,
                    avaliacao_id: null,
                    avaliador_id: null,
                    avaliado_id: null,
                    coordenador_id: null,
                    send_avaliador: null,
                    mensagem: null
                },
                toDelete: null,
                divisoes_tematicas: [],
                statusAvaliador: [
                    { id: "Avaliado" , descricao: "Avaliado"},
                    { id: "Em Análise" , descricao: "Em Análise"},
                ],
                statusCoordenador: [
                    { id: "Avaliado" , descricao: "Avaliado"},
                    { id: "Em Análise" , descricao: "Em Análise"},
                ],
                searchType: { link: 'titulo', text: 'TITULO' },
                }
        },
        watch: {
            modalidade: {
                handler:function(newVal) {
                    if(newVal){
                        this.modalidade_search = newVal.modalidade_search
                    }
                },
                deep:true
            },
            categoria: {
                handler:function(newVal) {
                    if(newVal){
                        this.categoria_search = newVal.categoria_search
                    }
                },
                deep:true
            }
        },
        methods: {
            sorts:function(s) {
                if(s === this.currentSort) {
                    this.currentSortDir = this.currentSortDir==='asc'?'desc':'asc';

                }
                this.currentSort = s;
            },
            calc_media(registro){
                if (registro && registro.avaliacao && registro.avaliacao.media_final == null) {
                    let media_final = (registro.avaliacao.media_1 + registro.avaliacao.media_2 + registro.avaliacao.media_3) / 3

                    return media_final.toString().substring(5, 0)
                } else if(registro && registro.avaliacao && registro.avaliacao.media_final != null){
                    return registro.avaliacao.media_final.toString().substring(5, 0)
                }
                return "Sem média geral"

            },
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
            async getChat(avaliacao, indexChat) {
                if(avaliacao && avaliacao.id){
                    await axios.get(`${this.baseUrl}/coordenador/expocom/get/chat/${avaliacao.id}`)
                    .then(res =>{
                        if(res.data.length > 0){
                            this.mensagens = res.data
                            this.selectedChat.avaliacao_id = (res.data && res.data[0]) ? res.data[0].avaliacao_id : avaliacao && avaliacao.id ? avaliacao.id : null
                            this.selectedChat.coordenador_id = this.coordenador ? this.coordenador.id : null
                            this.selectedChat.coordenador = this.coordenador ? this.coordenador : null
                            this.selectedChat.send_avaliador = indexChat ? indexChat : null
                            this.selectedChat.avaliacao = avaliacao ? avaliacao : null
                            this.selectedChat.mensagem = null
                            this.$validator.reset('mensagens')

                        } else{
                            this.mensagens = []
                            this.selectedChat.id = avaliacao && avaliacao.id ? avaliacao.id : null
                            this.selectedChat.avaliacao_id = (res.data && res.data[0]) ? res.data[0].avaliacao_id : avaliacao && avaliacao.id ? avaliacao.id : null
                            this.selectedChat.coordenador_id = this.coordenador ? this.coordenador.id : null
                            this.selectedChat.coordenador = this.coordenador ? this.coordenador : null
                            this.selectedChat.send_avaliador = indexChat ? indexChat : null
                            this.selectedChat.avaliacao = avaliacao ? avaliacao : null
                            this.$validator.reset('mensagens')
                        }

                        if(indexChat == 1){
                            $('#modalChat').modal({backdrop: 'static', keyboard: false, show: true})
                            this.$bvModal.show('modalChat')
                        }

                        if(indexChat == 2){
                            $('#modalChat2').modal({backdrop: 'static', keyboard: false, show: true})
                            this.$bvModal.show('modalChat2')
                        }

                        if(indexChat == 3){
                            $('#modalChat3').modal({backdrop: 'static', keyboard: false, show: true})
                            this.$bvModal.show('modalChat3')
                        }
                    })
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
            viewSub(registro){
                this.selectedSub = registro
                $('#modalSub').modal({backdrop: 'static', keyboard: false, show: true})
                this.$bvModal.show('modalSub')
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
            find_dt(registro){
                if(registro && registro.inscricao && registro.inscricao.categoria_inscricao){
                    let selectedDt =  this.divisoes_tematicas.find(dt => dt.id == registro.inscricao.categoria_inscricao)
                    let dt = selectedDt ? selectedDt.dt : ''
                    let dt_descricao = selectedDt ? selectedDt.descricao : ''
                    let returno = dt+' - '+dt_descricao
                    return returno ? returno : "NI"
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
            getModalidade() {
                if(this.categoria && this.categoria.categoria_search) {
                    switch (this.categoria.categoria_search)
                    {
                    case "Cinema e Audiovisual":
                        this.modalidades = this.cinema_audiovisual;
                        break;
                    case "Jornalismo":
                        this.modalidades = this.jornalismo;
                        break;
                    case "Produção Transdisciplinar":
                        this.modalidades = this.producao_editorial;
                        break;
                    case "Publicidade e Propaganda":
                        this.modalidades = this.publicidade_propaganda;
                        break;
                    case "Rádio, TV e Internet":
                        this.modalidades = this.radio_internet;
                        break;
                    case "Relações Públicas":
                        this.modalidades = this.relacoes_publicas;
                        break;
                    default: 
                        this.modalidades = null;
                    }
                }
            },
            getCinemaAudiovisual(){
                let urlgetCinemaAudiovisual = this.baseUrl+"/get/cinema-audiovisual";

                $.ajax({
                    method: "GET",
                    url: urlgetCinemaAudiovisual,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.cinema_audiovisual = res
                    },
                    error: (res) => {
                        console.log(res)
                        
                    }
                }); 
            },
            getJornalismo(){
                let urlgetJornalismo = this.baseUrl+"/get/jornalismo";
                $.ajax({
                    method: "GET",
                    url: urlgetJornalismo,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.jornalismo = res
                    },
                    error: (res) => {
                        console.log(res)
                        
                    }
                }); 
            },
            getPublicidadePropaganda(){
                let urlgetPublicidadePropaganda = this.baseUrl+"/get/publicidade-propaganda";
                $.ajax({
                    method: "GET",
                    url: urlgetPublicidadePropaganda,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.publicidade_propaganda = res
                    },
                    error: (res) => {
                        console.log(res)
                        
                    }
                }); 
            },
            getRelacoesPublicas(){
                let urlgetRelacoesPublicas = this.baseUrl+"/get/relacoes-publicas";
                $.ajax({
                    method: "GET",
                    url: urlgetRelacoesPublicas,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.relacoes_publicas = res
                    },
                    error: (res) => {
                        console.log(res)
                        
                    }
                }); 
            },
            getProdEdit(){
                let urlgetProdEdit = this.baseUrl+"/get/producao-editorial";
                $.ajax({
                    method: "GET",
                    url: urlgetProdEdit,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.producao_editorial = res
                    },
                    error: (res) => {
                        console.log(res)
                        
                    }
                }); 
            },
            getRadioInternet(){
                let urlgetRadioInternet = this.baseUrl+"/get/radio-internet";
                $.ajax({
                    method: "GET",
                    url: urlgetRadioInternet,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.radio_internet = res
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
        computed: {
            sortedRegistros:function() {
                return this.registros.sort((a,b) => {

                    let modifier = 1;

                    if(this.currentSortDir == 'desc') modifier = -1;

                    let aa = a && a.avaliacao && a.avaliacao[this.currentSort] != null ? a.avaliacao[this.currentSort] : 0;
                    let bb = b && b.avaliacao && b.avaliacao[this.currentSort] != null ? b.avaliacao[this.currentSort] : 0;
                    aa = Math.round(aa,1)
                    bb = Math.round(bb,1)
                    
                    if(aa < bb ) return -1 * modifier;
                    if(aa > bb) return 1 * modifier;

                    return 0;
                });
            }
        },
        async created() {
            this.regiao_search = this.regiao

            await this.getLoggedUser().then(() => this.get())
            this.get = debounce(this.get, 500)
            this.getCoordenador(),
            this.getDivisoesTematicas(),
            this.getCinemaAudiovisual(),
            this.getJornalismo(),
            this.getPublicidadePropaganda(),
            this.getRelacoesPublicas(),
            this.getProdEdit(),
            this.getRadioInternet()

            if(this.regiao == 1){
                this.regiao_nome = "Sul"
            }

            if(this.regiao == 2){
                this.regiao_nome = "Nordeste"
            }

            if(this.regiao == 3){
                this.regiao_nome = "Sudeste"
            }

            if(this.regiao == 4){
                this.regiao_nome = "Centro-Oeste"
            }

            if(this.regiao == 5){
                this.regiao_nome = "Norte"
            }
        },
        mounted() {
            this.$refs['scroll'].addEventListener('scroll', debounce(this.handleScroll, 500))
        },
        destroyed () {
            this.$refs['scroll'].removeEventListener('scroll', this.handleScroll)
        },
    }
</script>
