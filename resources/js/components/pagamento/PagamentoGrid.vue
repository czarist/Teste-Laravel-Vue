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
                                         
                   
                    <div class="table-responsive scroll" ref="scroll" v-show="!loading && registros.length > 0">
                        <table class="table table-sm table-striped table-hover table-bordered" v-if="user">
                            <thead>
                                <tr>
                                    <th
                                        class="align-middle text-center"
                                        width="10%">
                                        Pagamento 
                                    </th>
                                    <th class="align-middle text-center" width="10%">DATA</th>
                                    <th class="align-middle text-center" width="10%">VALOR</th>
                                    <th class="align-middle text-center" width="10%">STATUS</th>
                                    <th class="align-middle text-center" width="10%">TIPO DE PAGAMENTO</th>
                                    <th class="align-middle text-center" width="10%">AÇÂO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(registro, index) in registros" :key="index">
                                    <td class="align-middle text-center">{{ registro && registro.user ? registro.user.name : "NI" }}</td>
                                    <td class="align-middle text-center">{{ registro.created_at | momentDate }}</td>
                                    <td class="align-middle text-center">{{ registro.vendas_item.valor_total | formatPrice }}</td>
                                    <td class="align-middle text-center">{{ registro && registro.pagamento && registro.pagamento.status  ? registro.pagamento.status.nome : "NI" }}</td>
                                    <td class="align-middle text-center">{{ registro && registro.pagamento && registro.pagamento.tipo_pgto  ? registro.pagamento.tipo_pgto.nome : "NI" }}</td>
                                    <td class="align-middle text-center">
                                        <span class="d-flex justify-content-center">
                                            <span
                                                class="btn btn-outline-primary btn-sm mr-1"
                                                @click="showVisualizar(registro)"
                                            ><i class="fa-solid fa-eye"> Visualizar</i>
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
        <visualizar-modal :selected="selected"></visualizar-modal>
        <notifications group="submit" position="center bottom" />
    </div>
</template>

<script>
    import debounce from 'debounce'
    import moment from 'moment'
    import GridMixin from '../mixins/grid-mixin'


    export default {
        mixins: [GridMixin],
        components: {
                VisualizarModal: () => import('./VisualizarModal.vue')
        },
        data() {
            return {
                value: 100,
                max: 100,
                page: 'pagamento',
                baseUrl: process.env.MIX_BASE_URL,
                moment: moment,
                loading: true,
                selected: null,
                toDelete: null,
            }
        },
        methods: {
            showVisualizar(registro) {
                this.selected = registro
                $('#form').modal({backdrop: 'static', keyboard: false, show: true})
                this.$bvModal.show('visualizarModal')
            },

        },
        async created() {
            await this.getLoggedUser().then(() => this.get())
            this.get = debounce(this.get, 500)
        },
        mounted() {
            this.$refs['scroll'].addEventListener('scroll', debounce(this.handleScroll, 500))
        },
        destroyed () {
            this.$refs['scroll'].removeEventListener('scroll', this.handleScroll)
        },
    }
</script>
