<template>
    <div class="mt-5">
        <h5 class="col-12 d-flex justify-content-between">
            Lista de Trabalhos - Expocom {{ regiao_nome ? regiao_nome : '' }}
        </h5>
        <div class="col-12">
            <div class="card-header">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" :href="baseUrl+'/lista-trabalhos-expocom/view/2'">Expocom</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" :href="baseUrl+'/lista-trabalhos/view/2'">DT,IJ, MESA</a>
                    </li>
                </ul>
            </div>
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
                        <table class="table table-sm table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th
                                        class="align-middle text-center"
                                        width="5%"
                                        @click="handleSort('id')"
                                        style="font-size: 9px !important;">
                                        Insc-Trab 
                                        
                                    </th>
                                    <th class="align-middle text-center" width="5%" style="font-size: 9px !important;">AUTOR</th>
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
                                    <th class="align-middle text-center" width="3%" style="font-size: 9px !important;">PDF</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(registro, index) in sortedRegistros" :key="index">
                                    <td class="align-middle text-center">{{ registro && registro.inscricao ? registro.inscricao.id : "NI" }}- {{ registro ? registro.id : "NI" }}</td>
                                    <td class="align-middle text-center">{{ registro && registro.inscricao && registro.inscricao.user && registro.inscricao.user.name ? registro.inscricao.user.name : "NI" }}</td>

                                    <td class="align-middle text-center">
                                            <button 
                                                type="button" 
                                                class="btn btn-outline-info btn-sm"
                                                @click="viewSub(registro)"
                                            >
                                                {{ registro && registro.inscricao && registro.inscricao.user && registro.inscricao.user.indicacao && registro.inscricao.user.indicacao.titulo_trabalho ? registro.inscricao.user.indicacao.titulo_trabalho.substring(50, 0) : "NI" }}
                                            </button>

                                    </td>
                                    <td class="align-middle text-center">{{ registro && registro.inscricao && registro.inscricao.user &&  registro.inscricao.user.indicacao && registro.inscricao.user.indicacao.modalidade ? registro.inscricao.user.indicacao.modalidade.substring(6, 0) : "NI" }}</td>
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
        <visualizar-submissao-modal :selectedSub="selectedSub"></visualizar-submissao-modal>

        <notifications group="submit" position="center bottom" />
    </div>
</template>

<script>
    import debounce from 'debounce'
    import GridMixin from '../mixins/grid-noauth-mixin'
    import VisualizarSubmissaoModal from './VisualizarSubmissaoModal.vue'

    export default {
        props: ['regiao'],
        mixins: [GridMixin],
        components: {
            VisualizarSubmissaoModal:() => import('./VisualizarSubmissaoModal.vue')
        },
        data() {
            return {
                value: 100,
                max: 100,
                page: 'lista-trabalhos-expocom',
                baseUrl: process.env.MIX_BASE_URL,
                loading: true,
                scroll: false,
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
                selectedSub: null,
                toDelete: null,
                divisoes_tematicas: [],
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

            this.get(),
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
