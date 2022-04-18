<template>
    <div class="mt-4">
        <h5 class="col-12 d-flex justify-content-between">
            Área de Pagamentos
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
                                    <a class="dropdown-item" @click="searchType = { link: 'email', text: 'E-mail' }">E-mail</a>
                                </div>
                            </div>
                        </div> 

                        <div class="input-group input-group-sm col-4 col-sm-4 col-md-4 col-lg-4 mb-1">
                                <span class="invalid-feedback">*Pesquisar por produto</span>
                            <div class="input-group-prepend mb-2">
                                <span class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                </span>
                            </div>

                            <v-select
                                class="flex-fill"
                                :name="`categoria`"
                                :disabled="loading"
                                :options="produtos"
                                :reduce="produto => produto.id"
                                v-model="produto.produto_search"
                                label="categoria"
                                @input="get()"
                                placeholder="Buscar tipo de pagamento..."
                            >
                                <template #selected-option="{ categoria }">
                                    <em>{{ categoria }}</em>
                                </template>
                            </v-select>
                        </div>

                        <div class="input-group input-group-sm col-4 col-sm-4 col-md-4 col-lg-4 mb-1">
                                <span class="invalid-feedback">*Status de pagamento</span>
                            <div class="input-group-prepend mb-2">
                                <span class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                </span>
                            </div>

                            <v-select
                                class="flex-fill"
                                :name="`status`"
                                :disabled="loading"
                                :options="statuses"
                                :reduce="status => status.id"
                                v-model="status"
                                label="nome"
                                @input="get()"
                                placeholder="Buscar por status..."
                            >
                                <template #selected-option="{ nome }">
                                    <em>{{ nome }}</em>
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
                                        Usuário 
                                    </th>
                                    <th class="align-middle text-center" width="5%">TIPO DE PAGAMENTO</th>
                                    <th class="align-middle text-center" width="5%">DATA</th>
                                    <th class="align-middle text-center" width="5%">VALOR</th>
                                    <th class="align-middle text-center" width="5%">STATUS</th>
                                    <th class="align-middle text-center" width="5%">MÉTODO DE PAGAMENTO</th>
                                    <th class="align-middle text-center" width="5%">AÇÂO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(registro, index) in registros" :key="index">
                                    <td class="align-middle text-center">{{ registro && registro.user ? registro.user.name : "NI" }}</td>
                                    <td class="align-middle text-center">{{ find_produto(registro) }}</td>
                                    <td class="align-middle text-center">{{ registro.created_at | momentDate }}</td>
                                    <td class="align-middle text-center">{{ find_format_price(registro) }}</td>
                                    <td class="align-middle text-center">{{ registro && registro.pagamento && registro.pagamento.status  ? registro.pagamento.status.nome : "NI" }}</td>
                                    <td class="align-middle text-center">{{ registro && registro.pagamento && registro.pagamento.tipo_pgto  ? registro.pagamento.tipo_pgto.nome : "NI" }}</td>
                                    <td class="align-middle text-center">
                                        <span class="d-flex justify-content-center">
                                            <span
                                                class="btn btn-sm mr-1"
                                                :class="registro.pagamento.status.id == 3 || registro.pagamento.status.id == 4 ? 'btn-outline-success' : 'btn-outline-danger'"
                                                @click="showPagar(registro)"
                                                :disabled="registro.pagamento.status.id == 3 || registro.pagamento.status.id == 4 ? true : loading"
                                            >
                                                {{ registro.pagamento.status.id == 3 || registro.pagamento.status.id == 4 ? "PAGO" : "CONFIRMAR PAGAMENTO" }}
                                            </span>
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
        <pagar-modal :selected="selected"></pagar-modal>
        <notifications group="submit" position="center bottom" />
    </div>
</template>

<script>
    import debounce from 'debounce'
    import moment from 'moment'
    import GridMixin from '../../mixins/grid-mixin'


    export default {
        mixins: [GridMixin],
        components: {
                VisualizarModal: () => import('./VisualizarModal.vue'),
                PagarModal: () => import('./PagarModal.vue')
        },
        data() {
            return {
                value: 100,
                max: 100,
                page: 'admin/pagamentos',
                baseUrl: process.env.MIX_BASE_URL,
                moment: moment,
                loading: true,
                selected: null,
                toDelete: null,
                produtos: [
                    { id: 2, categoria: 'Anuidade 2022'},
                    { id: 3, categoria: 'Regional Sul'},
                    { id: 4, categoria: 'Regional Nordeste'},
                    { id: 5, categoria: 'Regional Sudeste'},
                    { id: 6, categoria: 'Regional Crentro-Oeste'},
                    { id: 7, categoria: 'Regional Norte'},
                    { id: 8, categoria: 'Nacional'}
                ],
                searchType: { link: 'cpf', text: 'CPF' },
                produto:{
                    produto_search: null,
                },

            }
        },
        watch: {
            produto: {
                handler:function(newVal) {
                    if(newVal){
                        this.produto_search = newVal.produto_search
                    }
                },
                deep:true
            }
        },
        methods: {
            showVisualizar(registro) {
                this.selected = registro
                $('#form').modal({backdrop: 'static', keyboard: false, show: true})
                this.$bvModal.show('visualizarModal')
            },
            showPagar(registro) {
                if(registro.pagamento.status.id != 3 && registro.pagamento.status.id != 4){

                    this.selected = registro
                    $('#pagarModal').modal({backdrop: 'static', keyboard: false, show: true})
                    this.$bvModal.show('pagarModal')
                }
            },

            find_produto(registro){
                if(registro && registro.vendas_item && registro.vendas_item.produto){
                    if(registro.vendas_item.produto.id == 1 || registro.vendas_item.produto.id == 2){
                        return "Anuidade 2022"
                    }

                    let produto = registro.vendas_item.produto.categoria + " - " + registro.vendas_item.produto.nome

                    return produto
                }
            },
            find_format_price(registro){
                if(registro && registro.vendas_item && registro.vendas_item.valor_total){
                    let value = registro.vendas_item.valor_total
                        let val = (value/1).toFixed(2).replace('.', ',')
                        return 'R$'+' ' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                }
                return ""
            },
            getTipoPagamento(){
                let url = this.baseUrl + '/get/status-pagamento'
                axios.get(url).then(response => {
                    this.statuses = response.data
                })
            },
        },
        async created() {
            await this.getLoggedUser().then(() => this.get())
            this.get = debounce(this.get, 500)
            this.getTipoPagamento()
        },
        mounted() {
            this.$refs['scroll'].addEventListener('scroll', debounce(this.handleScroll, 500))
        },
        destroyed () {
            this.$refs['scroll'].removeEventListener('scroll', this.handleScroll)
        },
    }
</script>
