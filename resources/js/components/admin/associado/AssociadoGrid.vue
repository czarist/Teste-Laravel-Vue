<template>
    <div class="mt-4">
        <h5 class="col-12 d-flex justify-content-between">
            Associados
            <span class="btn btn-success btn-sm" @click="showForm(null)">
                <i class="bi bi-plus-square"></i> Cadastrar
            </span>
        </h5>
        <div class="col-12">
            <div class="card">
                <div class="card-body pb-2">
                    <div v-if="loading">
                        <h5 class="d-flex justify-content-center">Carregando...</h5>
                        <b-progress :value="value" :max="max" ></b-progress>
                    </div>
                 
                    <div class="input-group input-group-sm mb-3"  v-show="!loading">
                        <div class="input-group-prepend">
                            <span class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                        <input
                            style="cursor: text; background-color: #fff;"
                            id="search"
                            type="text"
                            readonly
                            @focus="removeReadonly('search')"
                            class="form-control form-control-filter"
                            placeholder="Pesquisar..."
                            v-model="search"
                            @input="get()"
                        >
                    </div>
                        
                   
                    <div class="table-responsive scroll" ref="scroll" v-show="!loading && registros.length > 0">
                        <table class="table table-sm table-striped table-hover table-bordered" v-if="user">
                            <thead>
                                <tr>
                                    <th
                                        class="align-middle text-center"
                                        width="10%"
                                        @click="handleSort('numero_socio')">
                                        <i class="fas" :class="{
                                            'fa-sort' : sort!= 'numero_socio',
                                            'fa-sort-up' : sort== 'numero_socio' && asc == true,
                                            'fa-sort-down' : sort== 'numero_socio' && asc == false
                                        }"></i> Número Sócio 
                                    </th>
                                    <th class="align-middle text-center" width="3%">Anuidade</th>
                                    <th class="align-middle text-center" width="3%">Divisão temática</th>
                                    <th class="align-middle text-center" width="3%">Instituição</th>
                                    <th class="align-middle text-center" width="3%">Titulação</th>
                                    <th class="align-middle text-center" width="3%">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(registro, index) in registros" :key="index">
                                    <td class="align-middle text-center">{{ registro ? registro.numero_socio : "NI" }}</td>
                                    <td class="align-middle text-center">{{ registro.anuidade  | momentDate }}</td>
                                    <td class="align-middle text-center">{{ registro ? registro.divisao_tematica : "NI" }}</td>
                                    <td class="align-middle text-center">{{ registro && registro.instituicao ? registro.instituicao.instituicao  : "NI" }}</td>
                                    <td class="align-middle text-center">{{ registro && registro.titulacao ? registro.titulacao.titulacao  : "NI" }}</td>
                                    <td class="align-middle text-center">
                                        <span class="d-flex justify-content-center">
                                            <span
                                                class="btn btn-outline-primary btn-sm mr-1"
                                                @click="showForm(registro)"
                                            ><i class="bi bi-pencil-square">Editar</i></span>

                                            <span
                                               class="btn btn-outline-danger btn-sm"
                                              @click="showDelete(registro)"
                                            ><i class="bi bi-trash"></i> Deletar</span>
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
        <form-associado @store="store($event)" @update="update($event)" :selected="selected"></form-associado>
        <delete-modal @destroy="destroy"></delete-modal>
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
            FormAssociado: () => import('./FormAssociado' /* webpackChunkName: "form-associado" */),
            DeleteModal: () => import('../../shared/components/DeleteModal' /* webpackChunkName: "delete-modal" */),
        },
        data() {
            return {
                value: 100,
                max: 100,
                page: 'admin/associado',
                baseUrl: process.env.MIX_BASE_URL,
                loading: true,
                selected: null,
                toDelete: null,
            }
        },
        methods: {
            showForm(registro) {
                this.selected = registro
                $('#form').modal({backdrop: 'static', keyboard: false, show: true})
                this.$bvModal.show('associadoModal')
            },
            showDelete(registro) {
                this.toDelete = registro
                this.$bvModal.show('deleteModal')
            },
            store($event) {
                this.registros.splice(0, 0, $event)
                this.$bvModal.hide('associadoModal')
                this.total++
            },
            update($event) {
                let index = this.registros.findIndex(registro => registro.id == this.selected.id)
                this.registros.splice(index, 1, $event)
                this.$bvModal.hide('associadoModal')
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
