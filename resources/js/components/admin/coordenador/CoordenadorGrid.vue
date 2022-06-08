<template>
    <div class="mt-4">
        <h5 class="col-12 d-flex justify-content-between">
            Lista de Usuários/Coordenadores
        </h5>
        <div class="col-12">
            <div class="card">
                <div class="card-body pb-2">
                    <div v-if="loading">
                        <h5 class="d-flex justify-content-center">Carregando...</h5>
                        <b-progress :value="value" :max="max" ></b-progress>
                    </div>
                   
                    <div class="row mb-3 d-flex justify-content-between" v-if="!loading">
                        <div class="input-group input-group-sm col-12 col-sm-12 col-md-4">
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

                        <div class="input-group input-group-sm col-12 col-sm-12 col-md-4 ">
                            <span class="invalid-feedback">* Clique no status para pesquisar por todos usuários </span>

                            <div class="input-group-prepend" style="display:block !important;">
                                <span class="btn btn-primary">
                                    <i class="bi bi-activity"></i>
                                </span>
                            </div>
                            <select aria-placeholder="Status..." class="form-control form-control-filter mb-2 mb-lg-0" v-model="status" @change="get()">
                                <option selected value="0">Status...</option>
                                <option v-for="status in statuses" :key="status.id" :value="status.id">{{ status.descricao }}</option>
                            </select>

                        </div>
                    </div>
                       
                   
                    <div class="table-responsive scroll" ref="scroll" v-show="!loading && registros.length > 0">
                        <table class="table table-sm table-striped table-hover table-bordered" v-if="user">
                            <thead>
                                <tr>
                                    <th
                                        class="align-middle text-center"
                                        width="40%"
                                        @click="handleSort('tipo_usuario')">
                                        <i class="bi" :class="{
                                            'bi-funnel' : sort!= 'tipo_usuario',
                                            'bi-sort-up-alt' : sort== 'tipo_usuario' && asc == true,
                                            'bi-sort-down-alt' : sort== 'tipo_usuario' && asc == false
                                        }"></i> usuario 
                                    </th>
                                    <th
                                        class="align-middle text-center"
                                        width="15%"
                                        @click="handleSort('tipo')">
                                        <i class="bi" :class="{
                                            'bi-funnel' : sort!= 'tipo',
                                            'bi-sort-up-alt' : sort== 'tipo' && asc == true,
                                            'bi-sort-down-alt' : sort== 'tipo' && asc == false
                                        }"></i> Coordenador 
                                    </th>
                                    <th
                                        class="align-middle text-center"
                                        width="10%"
                                        @click="handleSort('tipo')">
                                        <i class="bi" :class="{
                                            'bi-funnel' : sort!= 'tipo',
                                            'bi-sort-up-alt' : sort== 'tipo' && asc == true,
                                            'bi-sort-down-alt' : sort== 'tipo' && asc == false
                                        }"></i> Tipo 
                                    </th>

                                    <th
                                        class="align-middle text-center"
                                        width="10%"
                                        @click="handleSort('regiao')">
                                        <i class="bi" :class="{
                                            'bi-funnel' : sort!= 'regiao',
                                            'bi-sort-up-alt' : sort== 'regiao' && asc == true,
                                            'bi-sort-down-alt' : sort== 'regiao' && asc == false
                                        }"></i> Região 
                                    </th>
                                    <th
                                        class="align-middle text-center"
                                        width="30%"
                                        @click="handleSort('dt')">
                                        <i class="bi" :class="{
                                            'bi-funnel' : sort!= 'dt',
                                            'bi-sort-up-alt' : sort== 'dt' && asc == true,
                                            'bi-sort-down-alt' : sort== 'dt' && asc == false
                                        }"></i> Categoria 
                                    </th>
                                    <th
                                        class="align-middle text-center"
                                        width="5%"
                                        @click="handleSort('ano')">
                                        <i class="bi" :class="{
                                            'bi-funnel' : sort!= 'ano',
                                            'bi-sort-up-alt' : sort== 'ano' && asc == true,
                                            'bi-sort-down-alt' : sort== 'ano' && asc == false
                                        }"></i> Ano 
                                    </th>
                                    <th class="align-middle text-center" width="3%">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(registro, index) in registros" :key="index">
                                    <td class="align-middle text-center">{{ registro ? registro.name : "NI" }}</td>
                                    <td class="align-middle text-center">
                                        {{ registro && registro.coordenador_regional ? "Sim" : "Não" }}
                                    </td>
                                    <td class="align-middle text-center">{{ registro && registro.coordenador_regional ? registro.coordenador_regional.tipo : "NI" }}</td>
                                    <td class="align-middle text-center">{{ registro && registro.coordenador_regional ? registro.coordenador_regional.regiao : "NI" }}</td>
                                    <td class="align-middle text-center">{{ registro && registro.coordenador_regional ? registro.coordenador_regional.dt : "NI" }}</td>
                                    <td class="align-middle text-center">{{ registro && registro.coordenador_regional ? registro.coordenador_regional.ano : "NI" }}</td>

                                    <td class="align-middle text-center">
                                        <span class="d-flex justify-content-center">
                                            <span
                                                class="btn btn-outline-primary btn-sm mr-1"
                                                @click="showForm(registro)"
                                            ><i class="bi bi-pencil-square"></i>Editar</span>

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
        <form-coordenador @store="store($event)" @update="update($event)" :selected="selected"></form-coordenador>
        <delete-modal @destroy="destroy"></delete-modal>
        <notifications group="submit" position="center bottom" />
    </div>
</template>

<script>
    import debounce from 'debounce'
    import GridMixin from '../../mixins/grid-mixin'


    export default {
        mixins: [GridMixin],
        components: {
            FormCoordenador: () => import('./FormCoordenador' /* webpackChunkName: "form-usuario" */),
            DeleteModal: () => import('./DeleteModal' /* webpackChunkName: "delete-modal" */),
        },
        data() {
            return {
                searchType: { link: 'name', text: 'Nome' },
                value: 100,
                max: 100,
                page: 'admin/coordenador',
                baseUrl: process.env.MIX_BASE_URL,
                loading: true,
                selected: null,
                toDelete: null,
                divisoes_tematicas: [],
                statuses: [
                    { id: 1 , descricao: "Todos os Usuários"}
                ],
            }
        },
        methods: {
            find_dt(registro){
                if(registro && registro.coordenador_regional && registro.coordenador_regional.dt){
                    let selectedDt =  this.divisoes_tematicas.find(dt => dt.id === registro.coordenador_regional.dt)
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
                this.registros.coordenador_regional.splice(0, 0, $event)
                this.$bvModal.hide('coordenadorModal')
                this.total++
            },
            update($event) {
                let index = this.registros.findIndex(registro => registro.coordenador_regional.id == this.selected.id)
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
