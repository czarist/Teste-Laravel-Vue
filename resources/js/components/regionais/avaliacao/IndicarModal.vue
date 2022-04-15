<template>
    <b-modal id="modalIndicar" size="lg" no-close-on-backdrop>
        <template #modal-header="{ close }">
            <h5>Cadastro de Trabalho para Análise</h5>
            <b-button size="sm" variant="outline-danger" @click="close()">X</b-button>
        </template>
        <template>
            <div class="text-center"><h6>Informe abaixo o avaliador para este resumo</h6></div>
            <b-row>
                <b-col cols="12" sm="6" lg="6">
                    <b-form-group label="Inscrição/Trabalho" label-class="font-weight-bold">
                        {{ post ? post.submissao_id : '' }} / {{ post ? post.inscricao_id : '' }}
                    </b-form-group>
                </b-col>

                <b-col cols="12" sm="6" lg="6">
                    <b-form-group label="Título" label-class="font-weight-bold">
                        {{ post ? post.titulo : '' }}
                    </b-form-group>
                </b-col>

                <b-col cols="12" sm="6" lg="6">
                    <b-form-group label="Área" label-class="font-weight-bold">
                        {{ find_dt(post) }}
                    </b-form-group>                
                </b-col>

                <b-col cols="12" sm="6" lg="6">
                    <b-form-group label="Avaliador 1" label-class="font-weight-bold">
                        <b-form-select
                            :disabled="loading"
                            name="avaliador_1"
                            v-validate="{ required: true }"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`avaliador_1`)}]"
                            size="sm"
                            data-vv-as="instituição"
                            class="form-control form-control-sm"
                            v-model="post.avaliador_1"
                        >
                            <option :value="null">Selecione</option>
                            <option v-for="avaliador in avaliadores" :value="avaliador" :key="avaliador.id">
                                {{ avaliador.name }} - {{ avaliador && avaliador.associado && avaliador.associado.instituicao ? avaliador.associado.instituicao.sigla_instituicao : '' }}
                            </option>
                        </b-form-select>

                        <span v-show="errors.has(`avaliador_1`)" class="invalid-feedback">
                            {{ errors.first(`avaliador_1`) }}
                        </span>
                    </b-form-group>
                </b-col>

                <b-col cols="12" sm="6" lg="6">
                    <b-form-group label="Avaliador 2" label-class="font-weight-bold">
                        <b-form-select
                            :disabled="loading"
                            name="avaliador_2"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`avaliador_2`)}]"
                            size="sm"
                            data-vv-as="instituição"
                            class="form-control form-control-sm"
                            v-model="post.avaliador_2"
                        >
                            <option :value="null">Selecione</option>
                            <option v-for="avaliador in avaliadores" :value="avaliador" :key="avaliador.id">
                                {{ avaliador.name }} - {{ avaliador && avaliador.associado && avaliador.associado.instituicao ? avaliador.associado.instituicao.sigla_instituicao : '' }}
                            </option>
                        </b-form-select>
                        <span v-show="errors.has(`avaliador_2`)" class="v-select-invalid-feedback">
                            {{ errors.first(`avaliador_2`) }}
                        </span>
                    </b-form-group>
                </b-col>


                <b-col cols="12" sm="6" lg="6">
                    <b-form-group label="Avaliador 3" label-class="font-weight-bold">
                        <b-form-select
                            :disabled="loading"
                            name="avaliador_3"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`avaliador_3`)}]"
                            size="sm"
                            data-vv-as="instituição"
                            class="form-control form-control-sm"
                            v-model="post.avaliador_3"
                        >
                            <option :value="null">Selecione</option>
                            <option v-for="avaliador in avaliadores" :value="avaliador" :key="avaliador.id">
                                {{ avaliador.name }} - {{ avaliador && avaliador.associado && avaliador.associado.instituicao ? avaliador.associado.instituicao.sigla_instituicao : '' }}
                            </option>
                        </b-form-select>
                        <span v-show="errors.has(`avaliador_3`)" class="v-select-invalid-feedback">
                            {{ errors.first(`avaliador_3`) }}
                        </span>
                    </b-form-group>
                </b-col>

            </b-row>

        </template>
            <template #modal-footer="{ cancel }">
                <b-button size="md" variant="outline-danger" @click="cancel()" :disabled="loading">
                    Cancelar
                </b-button>
                <b-button :disabled=" loading" size="md" variant="outline-success" @click="save()">
                    {{post.id ? 'Atualizar' : 'Cadastrar'}}
                </b-button>
        </template>
    </b-modal>
</template>

<script>
  import MixinsGlobal from  '../../mixins/global-mixins'
      export default {
        props: ['selectedIndicar', 'id'],
        mixins: [
            MixinsGlobal
        ],
        data() {
            return {
                baseUrl: process.env.MIX_BASE_URL,
                loading: false,
                verify: null,
                divisoes_tematicas: [],
                avaliadores_all: [],
                avaliadores: [],
                tipo: null,
                categoria: null,
                post: {
                    id: null,
                    titulo: null,
                    avaliador_1: null,
                    avaliador_2: null,
                    avaliador_3: null,
                    dt: [],
                    inscricao_id: null,
                    submissao_id: null,
                    regiao: null,
                    _method: 'post'
                },
            }
        },
        watch: {
            selectedIndicar() {
                if(this.selectedIndicar) {
                    this.$forceUpdate()
                    this.post.id = this.selectedIndicar && this.selectedIndicar.avaliacao ? this.selectedIndicar.avaliacao.id : null
                    this.post.inscricao_id = this.selectedIndicar ? this.selectedIndicar.inscricao_id : null
                    this.post.submissao_id = this.selectedIndicar ? this.selectedIndicar.id : null
                    this.post.regiao = this.selectedIndicar ? this.selectedIndicar.regiao : null
                    this.post.titulo = this.selectedIndicar ? this.selectedIndicar.titulo : null
                    this.post.dt = this.selectedIndicar ? this.selectedIndicar.dt : null
                    this.post.avaliador_1 = this.selectedIndicar && this.selectedIndicar.avaliacao  ? this.selectedIndicar.avaliacao.avaliador_1_obj : null
                    this.post.avaliador_2 = this.selectedIndicar && this.selectedIndicar.avaliacao ? this.selectedIndicar.avaliacao.avaliador_2_obj : null
                    this.post.avaliador_3 = this.selectedIndicar && this.selectedIndicar.avaliacao ? this.selectedIndicar.avaliacao.avaliador_3_obj : null
                    this.post.avaliacao = this.selectedIndicar && this.selectedIndicar.avaliacao ? this.selectedIndicar.avaliacao : null
                    this.post._method = this.post && this.post.id ? 'put' : 'post'
                    this.tipo = this.selectedIndicar && this.selectedIndicar.tipo ? this.selectedIndicar.tipo : null
                    this.categoria = this.selectedIndicar && this.selectedIndicar.dt ? this.selectedIndicar.dt : null

                    if(this.categoria && this.categoria != null && this.tipo && this.tipo != null){
                        if(this.tipo == "Intercom Júnior"){
                            let avaliador = []

                            this.avaliadores_all.forEach(ava => {
                                if(ava.todos_divisoes_tematicas_jr.find(dtij => dtij.id  == this.categoria)){
                                    avaliador.push(ava)
                                }
                            })
                            this.avaliadores = avaliador
                        }

                    }

                    if(this.categoria && this.categoria != null && this.tipo && this.tipo != null){
                        if(this.tipo == "Mesa" || this.tipo == "Divisões Temáticas"){
                            let avaliador = []

                            this.avaliadores_all.forEach(ava => {
                                if(ava.todos_divisoes_tematicas.find(dt => dt.id  == this.categoria)){
                                    avaliador.push(ava)
                                }
                            })
                            this.avaliadores = avaliador
                        }
                    }

                } else {
                    this.clear()
                }
            },
            post: {
                handler:function(newVal) {

                    if(newVal && newVal.avaliador_1){
                        this.post.status_avaliador_1 = "Em Análise"
                    }
                    if(newVal && newVal.avaliador_2){
                        this.post.status_avaliador_2 = "Em Análise"
                    }
                    if(newVal && newVal.avaliador_3){
                        this.post.status_avaliador_3 = "Em Análise"
                    }                  
                },
                deep:true
            }

        },
        computed: {
            url() {
                return this.post && this.post.id ? `/${this.post.id}` : ''
            },

        },
        methods: {
            find_dt(post){
                if(post && post.dt){
                    let selectedDt =  this.divisoes_tematicas.find(dt => dt.id === post.dt)
                    return selectedDt ? selectedDt.descricao : "NI"
                }
            },    
            async save() {
                this.loading = true
                if(this.post.dt.length > 1){
                    this.message('Erro', 'Selecione uma divisão temática apenas!', 'error');
                    this.loading = false
                    return

                }else{
                    await this.$validator.validateAll().then((valid) => {
                        if(valid) {
                            this.message('Aguarde...', 'Estamos salvando suas informações', 'info', -1);

                            setTimeout(() => {
                                axios.post(`${process.env.MIX_BASE_URL}/avaliacao${this.url}`, this.post).then( res => {
                                    
                                    this.clear()

                                    this.message('Sucesso', res.status == 201 ? 'Usuário cadastrado.' : 'Usuário atualizado.', 'success');
                                    
                                    window.location.reload()

                                    this.$bvModal.hide('modalIndicar')

                                }).catch(error => {
                                    if(error.response.status == 422) {
                                        if(error.response.data.message == "The given data was invalid.") {
                                            this.loading = false
                                            return this.message('Campos Obrigatórios', 'Preencha todos os campos obrigatórios', 'error');
                                        }
                                    }
                                    if(error.response.status == 500) {
                                        this.loading = false
                                        this.message('Erro', 'Por favor tente novamente.', 'error');
                                    }
                                    if(error.response.status == 403) {
                                        if(error.response.data.message == "This action is unauthorized.") {
                                            this.loading = false
                                            this.message('Erro', 'Ação não autorizada.', 'error');
                                        }
                                    }
                                })
                            },1000)
                        } else {
                            this.loading = false
                            this.message('Campos Obrigatórios', 'Preencha todos os campos obrigatórios', 'error');
                        }
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
            getAvaliadores(){
                let urlgetavaliadores = this.baseUrl+"/get/avaliadores";

                $.ajax({
                    method: "GET",
                    url: urlgetavaliadores,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.avaliadores_all = res
                    },
                    error: (res) => {
                        console.log(res)
                        
                    }
                }); 
            },
            clear() {
                this.post.id = null
                this.post.name = null
                this.post._method = 'post'
                this.$validator.reset('name')
            }
        },
        created() {
            this.getDivisoesTematicas(),
            this.getAvaliadores()

        },

    }
</script>

<style scoped>
    ::v-deep .modal-backdrop {
        opacity: 0.5 !important;
    }
</style>