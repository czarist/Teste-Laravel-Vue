<template>
    <div class="mt-4">
        <h5 class="col-12 d-flex justify-content-between">
            Validar Apresetação de Trabalho Expocom e Vencedor
        </h5>
        <div class="col-12">
            <div class="card">
                <div class="card-body pb-2">
                    <div v-if="loading">
                        <h5 class="d-flex justify-content-center">Carregando...</h5>
                        <b-progress :value="value" :max="max" ></b-progress>
                    </div>
                   
                    <div class="row d-flex align-items-center mb-3" v-if="!loading">

                        <div class="input-group input-group-sm col-6 col-sm-6 col-md-6 col-lg-6 mb-1">
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
                            <span class="invalid-feedback">*Filtrar por região</span>
                            <div class="input-group-prepend mb-2">
                                <span class="btn btn-primary">
                                    <i class="fa fa-search"></i>
                                </span>
                            </div>

                            <v-select
                                class="flex-fill"
                                :name="`regiao`"
                                :disabled="loading"
                                :options="regiao"
                                :reduce="regiao => regiao.id"
                                v-model="regiao_search"
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
                                        style="font-size: 9px !important;"
                                        width="5%"
                                        @click="handleSort('id')">Id 
                                    </th>
                                    <th
                                        class="align-middle text-center"
                                        width="20%"
                                        style="font-size: 9px !important;"                                        
                                        @click="handleSort('nome')">Nome 
                                    </th>
                                    <th
                                        class="align-middle text-center"
                                        width="5%"
                                        style="font-size: 9px !important;"
                                        @click="handleSort('cpf')">CPF 
                                    </th>
                                    <th class="align-middle text-center" width="10%" style="font-size: 9px !important;">Regional</th>
                                    <th class="align-middle text-center" width="15%" style="font-size: 9px !important;">Categoria</th>
                                    <th class="align-middle text-center" width="15%" style="font-size: 9px !important;">Modalidade</th>
                                    <th
                                        class="align-middle text-center"
                                        width="5%"
                                        style="font-size: 9px !important;"
                                        @click="handleSort('presenca')">Presença 
                                    </th>
                                    <th
                                        class="align-middle text-center"
                                        width="5%"
                                        style="font-size: 9px !important;"
                                        @click="handleSort('apresentacao')">Apresentou Trabalho 
                                    </th>
                                    <th
                                        class="align-middle text-center"
                                        width="5%"
                                        style="font-size: 9px !important;"
                                        @click="handleSort('vencedor')">Vencedor 
                                    </th>

                                    <th class="align-middle text-center" width="5%" style="font-size: 9px !important;">AÇÂO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(registro, index) in registros" :key="index">
                                    <td class="align-middle text-center " style="font-size: 11px !important;" >{{ registro ? registro.id : "Sem Informação" }}</td>
                                    <td class="align-middle text-center " style="font-size: 11px !important;">{{ registro ? registro.name : "Sem Informação" }}</td>
                                    <td class="align-middle text-center " style="font-size: 11px !important;">{{ registro ? registro.cpf : "Sem Informação" }}</td>
                                    <td class="align-middle text-center " style="font-size: 11px !important;">
                                        {{ registro && registro.regional_nordeste ? registro.regional_nordeste.regiao : "" }}
                                        {{ registro && registro.regional_sul ? registro.regional_sul.regiao : "" }}
                                        {{ registro && registro.regional_suldeste ? registro.regional_suldeste.regiao : "" }}
                                        {{ registro && registro.regional_centrooeste ? registro.regional_centrooeste.regiao : "" }}
                                        {{ registro && registro.regional_norte ? registro.regional_norte.regiao : "" }}
                                        {{ registro && registro.nacional ? "Nacional" : "" }}

                                    </td>
                                    <td class="align-middle text-center " style="font-size: 11px !important;">{{ registro && registro.indicacao && registro.indicacao.categoria ? registro.indicacao.categoria : "Sem Informação" }}</td>
                                    <td class="align-middle text-center " style="font-size: 11px !important;">{{ registro && registro.indicacao && registro.indicacao.modalidade ? registro.indicacao.modalidade : "Sem Informação" }}</td>

                                    <td class="align-middle text-center " style="font-size: 11px !important;">
                                        <div v-if="registro && registro.regional_norte && registro.regional_norte.presenca == 1 && regiao_search == 'Norte'">
                                            <span class="badge badge-success">
                                                <i class="fa fa-check"></i>
                                            </span>
                                        </div>
                                        <div v-else-if="registro && registro.regional_nordeste && registro.regional_nordeste.presenca == 1 && regiao_search == 'Nordeste'">
                                            <span class="badge badge-success">
                                                <i class="fa fa-check"></i>
                                            </span>
                                        </div>
                                        <div v-else-if="registro && registro.regional_sul && registro.regional_sul.presenca == 1 && regiao_search == 'Sul'">
                                            <span class="badge badge-success">
                                                <i class="fa fa-check"></i>
                                            </span>
                                        </div>
                                        <div v-else-if="registro && registro.regional_suldeste && registro.regional_suldeste.presenca == 1 && regiao_search == 'Sudeste'">
                                            <span class="badge badge-success">
                                                <i class="fa fa-check"></i>
                                            </span>
                                        </div>
                                        <div v-else-if="registro && registro.regional_centrooeste && registro.regional_centrooeste.presenca == 1 && regiao_search == 'Centro-Oeste'">
                                            <span class="badge badge-success">
                                                <i class="fa fa-check"></i>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center " style="font-size: 11px !important;">
                                        <div v-if="registro && registro.regional_norte && registro.regional_norte.submissao_expocom && registro.regional_norte.submissao_expocom.apresentacao == 1 && regiao_search == 'Norte'">
                                            <span class="badge badge-success">
                                                <i class="fa fa-check"></i>
                                            </span>
                                        </div>
                                        <div v-else-if="registro && registro.regional_nordeste && registro.regional_nordeste.submissao_expocom && registro.regional_nordeste.submissao_expocom.apresentacao == 1 && regiao_search == 'Nordeste'">
                                            <span class="badge badge-success">
                                                <i class="fa fa-check"></i>
                                            </span>
                                        </div>
                                        <div v-else-if="registro && registro.regional_sul && registro.regional_sul.submissao_expocom && registro.regional_sul.submissao_expocom.apresentacao == 1 && regiao_search == 'Sul'">
                                            <span class="badge badge-success">
                                                <i class="fa fa-check"></i>
                                            </span>
                                        </div>
                                        <div v-else-if="registro && registro.regional_suldeste && registro.regional_suldeste.submissao_expocom && registro.regional_suldeste.submissao_expocom.apresentacao == 1 && regiao_search == 'Sudeste'">
                                            <span class="badge badge-success">
                                                <i class="fa fa-check"></i>
                                            </span>
                                        </div>
                                        <div v-else-if="registro && registro.regional_centrooeste && registro.regional_centrooeste.submissao_expocom && registro.regional_centrooeste.submissao_expocom.apresentacao == 1 && regiao_search == 'Centro-Oeste'">
                                            <span class="badge badge-success">
                                                <i class="fa fa-check"></i>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center " style="font-size: 11px !important;">
                                        <div v-if="registro && registro.regional_norte && registro.regional_norte.submissao_expocom && registro.regional_norte.submissao_expocom.vencedor == 1 && regiao_search == 'Norte'">
                                            <span class="badge badge-success">
                                                <i class="fa fa-check"></i>
                                            </span>
                                        </div>
                                        <div v-else-if="registro && registro.regional_nordeste && registro.regional_nordeste.submissao_expocom && registro.regional_nordeste.submissao_expocom.vencedor == 1 && regiao_search == 'Nordeste'">
                                            <span class="badge badge-success">
                                                <i class="fa fa-check"></i>
                                            </span>
                                        </div>
                                        <div v-else-if="registro && registro.regional_sul && registro.regional_sul.submissao_expocom && registro.regional_sul.submissao_expocom.vencedor == 1 && regiao_search == 'Sul'">
                                            <span class="badge badge-success">
                                                <i class="fa fa-check"></i>
                                            </span>
                                        </div>
                                        <div v-else-if="registro && registro.regional_suldeste && registro.regional_suldeste.submissao_expocom && registro.regional_suldeste.submissao_expocom.vencedor == 1 && regiao_search == 'Sudeste'">
                                            <span class="badge badge-success">
                                                <i class="fa fa-check"></i>
                                            </span>
                                        </div>
                                        <div v-else-if="registro && registro.regional_centrooeste && registro.regional_centrooeste.submissao_expocom && registro.regional_centrooeste.submissao_expocom.vencedor == 1 && regiao_search == 'Centro-Oeste'">
                                            <span class="badge badge-success">
                                                <i class="fa fa-check"></i>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center" style="font-size: 11px !important;">
                                        <span>
                                            <a href="#" class="botaoazul p-1 m-1"
                                                v-tooltip.bottom="{
                                                content: 'Confirmar Apresentação de Trabalho',
                                                delay: 0,
                                                class: 'tooltip-custom tooltip-arrow'
                                                }"
                                                title="Confirmar Apresentação de Trabalho"
                                                @click="ConfirmarApresentacao(registro)"
                                            >Confirmar Apresentação                                                                                        
                                            </a>
                                        </span>
                                        <span>
                                            <a href="#" class="botaoazul p-1 m-1"
                                                v-tooltip.bottom="{
                                                content: 'Confirmar Vencedor Expocom',
                                                delay: 0,
                                                class: 'tooltip-custom tooltip-arrow'
                                                }"
                                                title="Confirmar Vencedor Expocom"
                                                @click="ConfirmarVencedor(registro)"
                                            >Confirmar Vencedor                                                                                        
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
        <visualizar-modal  @store="store($event)" :selected="selected"></visualizar-modal>
        <vencedor-modal  @store="store($event)" :selected="selected"></vencedor-modal>
        <notifications group="submit" position="center bottom" />
    </div>
</template>

<script>
    import debounce from 'debounce'
    import GridMixin from '../../mixins/grid-mixin'

    export default {
        mixins: [GridMixin],
        components: {
            VisualizarModal: () => import('./VisualizarModal.vue'),
            VencedorModal: () => import('./VencedorModal.vue')
        },
        data() {
            return {
                value: 100,
                max: 100,
                page: 'validar-apresentacao-expocom',
                baseUrl: process.env.MIX_BASE_URL,
                loading: true,
                scroll: false,
                toDelete: null,
                regiao_search: null,
                divisoes_tematicas: [],
                divisoes_tematicas_jr: [],
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

                regiao: [
                    { id: "Nordeste" , descricao: "Nordeste"},
                    { id: "Norte" , descricao: "Norte"},
                    { id: "Sudeste" , descricao: "Sudeste"},
                    { id: "Sul" , descricao: "Sul"},
                    { id: "Centro-Oeste" , descricao: "Centro-Oeste"}
                ],
                searchType: { link: 'cpf', text: 'CPF' },
                selected: [],
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
            find_dt(registro){
                if(registro && registro.dt){

                    if(registro && registro.tipo == "Mesa" || registro.tipo == "Divisões Temáticas"){
                        let selectedDt =  this.divisoes_tematicas.find(dt => dt.id === registro.dt)
                        let dt = selectedDt ? selectedDt.dt : ''
                        let dt_descricao = selectedDt ? selectedDt.descricao : ''
                        let returno = dt
                        return returno ? returno : "Sem Informação"

                    }

                    if(registro && registro.tipo == "Intercom Júnior"){
                        let selectedDt =  this.divisoes_tematicas_jr.find(dt => dt.id === registro.dt)
                        let dt = selectedDt ? selectedDt.dt : ''
                        let dt_descricao = selectedDt ? selectedDt.descricao : ''
                        let returno = dt
                        return returno ? returno : "Sem Informação"
                    }

                }
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
            store($event) {
                let index = this.registros.findIndex(registroFind => registroFind.id == $event.id)
                this.registros.splice(index, 1, $event)
                this.$bvModal.hide('visualizarModal')
                this.$bvModal.hide('vencedorModal')
                this.selected = null
            },
            ConfirmarApresentacao(registro){

                if(this.regiao_search == "Nordeste"){
                    var regiao = this.regiao_search
                    var submissao = registro.regional_nordeste.submissao_expocom.id
                    var regional = registro.regional_nordeste.id
                    var validado = registro.regional_nordeste.submissao_expocom.apresentacao
                }

                if(this.regiao_search == "Norte"){
                    var regiao = this.regiao_search
                    var submissao = registro.regional_norte.submissao_expocom.id
                    var regional = registro.regional_norte.id
                    var validado = registro.regional_norte.submissao_expocom.apresentacao
                }

                if(this.regiao_search == "Sudeste"){
                    var regiao = this.regiao_search
                    var submissao = registro.regional_suldeste.submissao_expocom.id
                    var regional = registro.regional_suldeste.id
                    var validado = registro.regional_suldeste.submissao_expocom.apresentacao
                }

                if(this.regiao_search == "Sul"){
                    var regiao = this.regiao_search
                    var submissao = registro.regional_sul.submissao_expocom.id
                    var regional = registro.regional_sul.id
                    var validado = registro.regional_sul.submissao_expocom.apresentacao
                }

                if(this.regiao_search == "Centro-Oeste"){
                    var regiao = this.regiao_search
                    var submissao = registro.regional_centrooeste.submissao_expocom.id
                    var regional = registro.regional_centrooeste.id
                    var validado = registro.regional_centrooeste.submissao_expocom.apresentacao
                }

                if(validado == 0){

                    var dados = {
                        user_id: registro.id,
                        regiao: regiao,
                        inscricao: regional,
                        submissao: submissao
                    }

                    this.selected = dados;
                    $('#visualizarModal').modal({backdrop: 'static', keyboard: false, show: true})
                    this.$bvModal.show('visualizarModal')

                }else{
                    this.$notify({
                        group: "submit",
                        title: "Erro!",
                        text: "Apresentação já confirmada.",
                        type: "error"
                    })
                }
            },
            ConfirmarVencedor(registro){

                if(this.regiao_search == "Nordeste"){
                    var regiao = this.regiao_search
                    var submissao = registro.regional_nordeste.submissao_expocom.id
                    var validado_apresentacao = registro.regional_nordeste.submissao_expocom.apresentacao
                    var validado_vencedor = registro.regional_nordeste.submissao_expocom.vencedor
                }

                if(this.regiao_search == "Norte"){
                    var regiao = this.regiao_search
                    var submissao = registro.regional_norte.submissao_expocom.id
                    var validado_apresentacao = registro.regional_norte.submissao_expocom.apresentacao
                    var validado_vencedor = registro.regional_norte.submissao_expocom.vencedor
                }

                if(this.regiao_search == "Sudeste"){
                    var regiao = this.regiao_search
                    var submissao = registro.regional_suldeste.submissao_expocom.id
                    var validado_apresentacao = registro.regional_suldeste.submissao_expocom.apresentacao
                    var validado_vencedor = registro.regional_suldeste.submissao_expocom.vencedor
                }

                if(this.regiao_search == "Sul"){
                    var regiao = this.regiao_search
                    var submissao = registro.regional_sul.submissao_expocom.id
                    var validado_apresentacao = registro.regional_sul.submissao_expocom.apresentacao
                    var validado_vencedor = registro.regional_sul.submissao_expocom.vencedor
                }

                if(this.regiao_search == "Centro-Oeste"){
                    var regiao = this.regiao_search
                    var submissao = registro.regional_centrooeste.submissao_expocom.id
                    var validado_apresentacao = registro.regional_centrooeste.submissao_expocom.apresentacao
                    var validado_vencedor = registro.regional_centrooeste.submissao_expocom.vencedor
                }

                if(validado_apresentacao == 1){

                    if(validado_vencedor == 0){

                        var dados = {
                            user_id: registro.id,
                            regiao: regiao,
                            submissao: submissao
                        }

                        this.selected = dados;
                        $('#vencedorModal').modal({backdrop: 'static', keyboard: false, show: true})
                        this.$bvModal.show('vencedorModal')
                    }else{
                        this.$notify({
                            group: "submit",
                            title: "Erro!",
                            text: "Vencedor já confirmado.",
                            type: "error"
                        })
                    }

                }else{
                    this.$notify({
                        group: "submit",
                        title: "Erro!",
                        text: "Precisa confirmar que o trabalho foi apresentado.",
                        type: "error"
                    })
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
            this.regiao_search = "Nordeste"
            await this.getLoggedUser().then(() => this.get())
            this.get = debounce(this.get, 500)
            this.getCoordenador()
            this.getDivisoesTematicas()
            this.getCinemaAudiovisual()
            this.getJornalismo()
            this.getPublicidadePropaganda()
            this.getRelacoesPublicas()
            this.getProdEdit()
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
