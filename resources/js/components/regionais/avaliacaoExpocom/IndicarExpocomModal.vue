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
                        <v-select
                            class="flex-fill"
                            :name="`avaliador_1`"
                            :disabled="loading"
                            :options="avaliadores"
                            :selectOnTab="false"
                            v-validate="{ required: true }"
                            v-model="post.avaliador_1"
                            label="name"
                            data-vv-as="Avaliador 1"
                            :class="{ 'v-select-invalid': errors.has(`avaliador_1`) }"
                        ></v-select>
                        <span v-show="errors.has(`avaliador_1`)" class="invalid-feedback">
                            {{ errors.first(`avaliador_1`) }}
                        </span>
                    </b-form-group>
                </b-col>

                <b-col cols="12" sm="6" lg="6">
                    <b-form-group label="Avaliador 2" label-class="font-weight-bold">
                        <v-select
                            class="flex-fill"
                            :name="`avaliador_2`"
                            :disabled="loading"
                            :options="avaliadores"
                            :selectOnTab="false"
                            v-model="post.avaliador_2"
                            label="name"
                            data-vv-as="Avaliador 1"
                            :class="{ 'v-select-invalid': errors.has(`avaliador_2`) }"
                        ></v-select>
                        <span v-show="errors.has(`avaliador_2`)" class="v-select-invalid-feedback">
                            {{ errors.first(`avaliador_2`) }}
                        </span>
                    </b-form-group>
                </b-col>


                <b-col cols="12" sm="6" lg="6">
                    <b-form-group label="Avaliador 3" label-class="font-weight-bold">
                        <v-select
                            class="flex-fill"
                            :name="`avaliador_3`"
                            :disabled="loading"
                            :options="avaliadores"
                            :selectOnTab="false"
                            v-model="post.avaliador_3"
                            label="name"
                            data-vv-as="Avaliador 1"
                            :class="{ 'v-select-invalid': errors.has(`avaliador_3`) }"
                        ></v-select>
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
                avaliadores: [],
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
                await this.$validator.validateAll().then((valid) => {
                    if(valid) {
                        this.message('Aguarde...', 'Estamos salvando suas informações', 'info', -1);

                        setTimeout(() => {
                            axios.post(`${process.env.MIX_BASE_URL}/avaliacaoexpocom${this.url}`, this.post).then( res => {
                                
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
                let urlgetavaliadores = this.baseUrl+"/get/avaliadores-expocom";

                $.ajax({
                    method: "GET",
                    url: urlgetavaliadores,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.avaliadores = res
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