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
                                    <td class="align-middle text-center" v-if="registro && registro.vendas_item">
                                        {{ registro.vendas_item.valor_total | formatPrice }}
                                    </td>
                                    <td class="align-middle text-center" v-else>
                                        Sem Informação
                                    </td>
                                    <td class="align-middle text-center">{{ registro && registro.pagamento && registro.pagamento.status  ? registro.pagamento.status.nome : "NI" }}</td>
                                    <td class="align-middle text-center">{{ registro && registro.pagamento && registro.pagamento.tipo_pgto  ? registro.pagamento.tipo_pgto.nome : "NI" }}</td>
                                    <td class="align-middle text-center">
                                        <span class="d-flex justify-content-center" v-if="registro && registro.pagamento">
                                            <span
                                                class="btn btn-outline-primary btn-sm m-1"
                                                @click="showVisualizar(registro)"
                                            >Visualizar
                                            </span>
                                        </span>

                                        <span class="d-flex justify-content-center" 
                                            v-if="registro && registro.pagamento && registro.pagamento.status_id == 3
                                            || registro && registro.pagamento && registro.pagamento.status_id == 4">
                                            <span
                                                class="btn btn-outline-success btn-sm m-1"
                                                @click="baixarRecibo(registro)"
                                            >Recibo de Pagamento
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
            baixarRecibo(registro){
                this.message('Aguarde...', 'Estamos buscando o seu recibo', 'info', -1);

                if(registro && registro.pagamento && registro.pagamento.status_id == 3
                || registro && registro.pagamento && registro.pagamento.status_id == 4){
                    let post = {
                        nome: registro && registro.user && registro.user.name ? registro.user.name : "",
                        cpf: registro && registro.user && registro.user.cpf ? registro.user.cpf : "",
                        valor: registro && registro.pagamento && registro.pagamento && registro.pagamento.valor_total ? registro.pagamento.valor_total : "",
                        produto_id: registro && registro.vendas_item && registro.vendas_item.produto_id ? registro.vendas_item.produto_id : "",
                        data_pagamento: registro && registro.pagamento && registro.pagamento.created_at ? registro.pagamento.created_at : "",
                        tipo_pagamento: registro && registro.pagamento && registro.pagamento.tipo_pgto && registro.pagamento.tipo_pgto.nome ? registro.pagamento.tipo_pgto.nome : "",
                        autenticacao: registro && registro.pagamento && registro.pagamento && registro.pagamento.transacao ? registro.pagamento.transacao : "",
                    }

                    axios.post(`${process.env.MIX_BASE_URL}/pagamento/recibo_pagamento`, post, {responseType: 'blob'}).then( res => {
                        if(res.data){
                            var newBlob = new Blob([res.data], {type: "application/pdf"})
                            const data = window.URL.createObjectURL(newBlob);
                            var link = document.createElement('a');
                            link.href = data;
                            link.download="recibo_pagamento.pdf";
                            link.click();
                            setTimeout(function(){
                                window.URL.revokeObjectURL(data);
                            }, 100);
                            this.message('Sucesso', 'Recibo baixado', 'success');

                        }else{
                            return this.message('Erro', 'Por favor tente novamente.', 'error');
                        }                            
                        
                    }).catch(error => {
                        if(error.response.status == 422) {
                            if(error.response.data.message == "The given data was invalid.") {
                                return this.message('Erro', 'Por favor tente novamente.', 'error');
                            }
                        }
                        if(error.response.status == 500) {
                            this.message('Erro', 'Por favor tente novamente.', 'error');
                        }
                        if(error.response.status == 403) {
                            if(error.response.data.message == "This action is unauthorized.") {
                                this.message('Erro', 'Ação não autorizada.', 'error');
                            }
                        }
                    })
                }
            }
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
