<template>
    <div class="mt-4">
        <h5 class="col-12 d-flex justify-content-between">
            Listagem de Indicações Expocom
        </h5>
        <div class="col-12">
            <div class="card">
                <div class="card-body pb-2">
                    <div v-if="loading">
                        <h5 class="d-flex justify-content-center">Carregando...</h5>
                        <b-progress :value="value" :max="max" ></b-progress>
                    </div>
                    
                    <div class="row mb-1">
                        <div class="input-group input-group-sm col-4 col-sm-4 col-md-4 col-lg-4 mb-1">
                            <span class="invalid-feedback">* Para pesquisar por CPF digite no formato: ###.###.###-##</span>
                            <div class="input-group-prepend mb-2">
                                <span class="btn btn-primary">
                                    <i class="fa fa-search"></i>
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
                                    class="btn btn-primary dropdown-toggle mb-2"
                                    type="button"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                >{{ searchType.text }} 
                                <i class="bi bi-caret-down-fill"></i>                            
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" @click="searchType = { link: 'name', text: 'Nome' }">Nome</a>
                                    <a class="dropdown-item" @click="searchType = { link: 'cpf', text: 'CPF' }">CPF</a>
                                    <a class="dropdown-item" @click="searchType = { link: 'titulo', text: 'Título' }">Título</a>
                                </div>
                            </div>
                        </div> 

                        <div class="input-group input-group-sm col-4 col-sm-4 col-md-4 col-lg-4 mb-1">
                            <span class="invalid-feedback">*Pesquisar por modalidade</span>

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

                        <div class="input-group input-group-sm col-4 col-sm-4 col-md-4 col-lg-4 mb-1">
                            <span class="invalid-feedback">*Pesquisar por categoria</span>

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
                                        width="10%">
                                        Autor 
                                    </th>
                                    <th class="align-middle text-center" width="5%">CPF Autor</th>
                                    <th class="align-middle text-center" width="10%">Categoria e Modalidade</th>
                                    <th class="align-middle text-center" width="5%">Titulo do Trabalho</th>
                                    <th class="align-middle text-center" width="5%">Trabalho Produzido</th>
                                    <th class="align-middle text-center" width="5%">AÇÂO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(registro, index) in registros" :key="index">
                                    <td class="align-middle text-center">{{ registro ? registro.nome_autor : "NI" }}</td>
                                    <td class="align-middle text-center">{{ registro ? registro.cpf_autor : "NI" }}</td>
                                    <td class="align-middle text-center">{{ find_categoria(registro) }}</td>
                                    <td class="align-middle text-center">{{ registro && registro.titulo_trabalho ? registro.titulo_trabalho.substring(40,0) : "NI" }}</td>
                                    <td class="align-middle text-center">{{ registro ? registro.trabalho_produzido : "NI" }}</td>
                                    <td class="align-middle text-center">
                                        <span class="d-flex justify-content-center">
                                            <span
                                                class="btn btn-sm btn-outline-success mr-1"
                                                @click="showForm(registro)"
                                            >
                                                Editar
                                            </span>

                                            <button
                                                class="btn btn-sm btn-outline-danger mr-1"
                                                @click="showDeleteModal(registro,index)">
                                                <i class="fas fa-trash-alt">Delete</i>
                                            </button>

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
        <form-indicacao @store="store($event)" @update="update($event)" :selected="selected"></form-indicacao>
        <delete-modal :selectedIndicacao="selectedIndicacao" @indicacaoDelete="indicacaoDelete($event)" ></delete-modal>
        <notifications group="submit" position="center bottom" />
    </div>
</template>

<script>
    import debounce from 'debounce'
    import moment from 'moment'
    import GridMixin from '../../mixins/grid-mixin'
    import FormIndicacao from './FormIndicacao.vue'
    import DeleteModal from './DeleteModal.vue'


    export default {
        mixins: [GridMixin],
        components: {
            FormIndicacao: () => import('./FormIndicacao'),
            DeleteModal: () => import('./DeleteModal')
        },
        data() {
            return {
                value: 100,
                max: 100,
                page: 'admin/indicacao',
                baseUrl: process.env.MIX_BASE_URL,
                moment: moment,
                loading: true,
                selected: null,
                selectedIndicacao: null,
                toDelete: null,
                categorias: [
                    { descricao: 'Cinema e Audiovisual', value: 'Cinema e Audiovisual'},
                    { descricao: 'Jornalismo', value: 'Jornalismo'},
                    { descricao: 'Produção Transdisciplinar', value: 'Produção Transdisciplinar'},
                    { descricao: 'Publicidade e Propaganda', value: 'Publicidade e Propaganda'},
                    { descricao: 'Rádio, TV e Internet', value: 'Rádio, TV e Internet'},
                    { descricao: 'Relações Públicas', value: 'Relações Públicas'}
                ],
                radio_internet: null,
                cinema_audiovisual: null,
                jornalismo: null,
                publicidade_propaganda: null,
                relacoes_publicas: null,
                producao_editorial: null,
                modalidades: [],
                categoria:{
                    categoria_search: null,
                },
                modalidade: {
                    modalidade_search: null
                },
                searchType: { link: 'name', text: 'Nome' },

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
            showForm(registro){
                this.getIndicacao(registro);
            },
            showDeleteModal(registro,index) {
                this.selectedIndicacao = null;
                this.selectedIndicacao = registro;
                this.selectedIndicacao.index = index;
                this.$bvModal.show('deleteModal')
            },
            indicacaoDelete() {
                this.loading = true;
                this.message('Deletando...', 'Aguarde deletando...', 'error');

                axios.get(`${process.env.MIX_BASE_URL}/admin/indicacao/delete/${this.selectedIndicacao.id}`).then(res => {

                    if(res.data.status){
                        this.loading = false
                        this.registros.splice(this.selectedIndicacao.index, 1);
                        this.selectedIndicacao = null;
                        this.$bvModal.hide('deleteModal')
                        this.message('Deletado...', 'Deletado com sucesso...', 'success');
                    }
                }).catch( e => {
                    this.loading = false
                    this.message('Erro...', 'Entre em contato via Whatsapp...', 'error');
                })
            },
            getIndicacao(registro){

                this.selected = null;

                axios.get(`${process.env.MIX_BASE_URL}/get/admin-indicacao-expocom-2022/${registro.id}`).then(res => {
                    this.selected = res.data;

                    $('#form').modal({backdrop: 'static', keyboard: false, show: true})
                    this.$bvModal.show('indicacaoModal')
                })
            },
            find_categoria(registro){
                if(registro && registro.categoria && registro.modalidade){

                    let categoria_modalidade = registro.categoria + " - " + registro.modalidade

                    return categoria_modalidade
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
            },
        },
        async created() {
            await this.getLoggedUser().then(() => this.get())
            this.get = debounce(this.get, 500)
            this.getCinemaAudiovisual(),
            this.getJornalismo(),
            this.getPublicidadePropaganda(),
            this.getRelacoesPublicas(),
            this.getProdEdit(),
            this.getRadioInternet()
        },
        mounted() {
            this.$refs['scroll'].addEventListener('scroll', debounce(this.handleScroll, 500))
        },
        destroyed () {
            this.$refs['scroll'].removeEventListener('scroll', this.handleScroll)
        },
    }
</script>
