<template>
    <b-modal id="associadoModal" no-close-on-backdrop>
        <template #modal-header="{ close }">
            <h5 v-if="post.id">Editar associado</h5>
            <h5 v-else>Cadastrar associado</h5>
            <b-button size="sm" variant="outline-danger" @click="close()">x</b-button>
        </template>
        <template>
            <b-row>
                <b-col cols="12" sm="6" lg="4">
                    <b-form-group label="Número sócio" label-class="font-weight-bold">
                        <b-form-input
                            name="numero_socio"
                            size="sm"
                            v-model="post.numero_socio"
                            type="text"
                            :disabled="loading"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`numero_socio`)}]"
                            v-validate="{ required: true,  numeroSocioCheck: post.id }"
                            aria-describedby="input-1-live-feedback"
                            data-vv-as="número sócio"
                        ></b-form-input>
                        <span v-show="errors.has(`numero_socio`)" class="invalid-feedback">
                            {{ errors.first(`numero_socio`) }}
                        </span>
                    </b-form-group>
                </b-col>

                <b-col cols="12" sm="6" lg="4">
                    <b-form-group label="Anuidade" label-class="font-weight-bold">
                        <b-form-input
                            name="anuidade"
                            size="sm"
                            v-model="post.anuidade"
                            :disabled="loading"
                            type="date"
                            v-validate="{ required: true }"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`anuidade`)}]"
                            aria-describedby="input-1-live-feedback"
                            data-vv-as="Anuidade"
                        ></b-form-input>
                        <span v-show="errors.has(`anuidade`)" class="invalid-feedback">
                            {{ errors.first(`anuidade`) }}
                        </span>
                    </b-form-group>
                </b-col>

                <b-col cols="12" sm="6" lg="4">
                    <b-form-group label="Instituição" label-class="font-weight-bold">
                        <b-form-select
                            :disabled="loading"
                            name="instituicao"
                            v-validate="{ required: true }"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`instituicao`)}]"
                            size="sm"
                            data-vv-as="instituição"
                            class="form-control form-control-sm"
                            v-model="post.instituicao_id"
                        >
                        <option :value="null">Selecione</option>
                        <option v-for="instituicao in instituicoes" :value="instituicao.id" :key="instituicao.id">
                            {{ instituicao.instituicao }}
                        </option>
                        </b-form-select>
                        <span v-show="errors.has(`instituicao`)" class="invalid-feedback">
                            {{ errors.first(`instituicao`) }}
                        </span>
                    </b-form-group>
                </b-col>

                <b-col cols="12" sm="6" lg="4">
                    <b-form-group label="Titulação" label-class="font-weight-bold">
                        <b-form-select
                            :disabled="loading"
                            name="titulacao"
                            v-validate="{ required: true }"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`titulacao`)}]"
                            size="sm"
                            data-vv-as="titulação"
                            class="form-control form-control-sm"
                            v-model="post.titulacao_id"
                        >
                        <option :value="null">Selecione</option>
                        <option v-for="titulacao in titulacoes" :value="titulacao.id" :key="titulacao.id">
                            {{ titulacao.titulacao }}
                        </option>
                        </b-form-select>
                        <span v-show="errors.has(`titulacao`)" class="invalid-feedback">
                            {{ errors.first(`titulacao`) }}
                        </span>
                    </b-form-group>
                </b-col>

                <b-col cols="12" sm="6" lg="4">
                    <b-form-group label="Divisão temática" label-class="font-weight-bold">
                        <b-form-input
                            name="divisao_tematica"
                            size="sm"
                            :disabled="loading"
                            v-model="post.divisao_tematica"
                            type="text"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`divisao_tematica`)}]"
                            v-validate="{ required: true }"
                            aria-describedby="input-1-live-feedback"
                            data-vv-as="Divisão temática"
                        ></b-form-input>
                        <span v-show="errors.has(`divisao_tematica`)" class="invalid-feedback">
                            {{ errors.first(`divisao_tematica`) }}
                        </span>
                    </b-form-group>
                </b-col>

                <b-col cols="12" sm="6" lg="4">
                    <b-form-group label="Obs Insentamos" label-class="font-weight-bold">
                        <b-form-input
                            name="obs_isentamos"
                            size="sm"
                            :disabled="loading"
                            v-model="post.obs_isentamos"
                            type="text"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`obs_isentamos`)}]"
                            aria-describedby="input-1-live-feedback"
                        ></b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
            
        </template>
            <template #modal-footer="{ cancel }">
                 <b-button size="md" variant="outline-danger" @click="cancel()" :disabled="loading">
                    Cancelar
                </b-button>
                <b-button size="md" variant="outline-success" @click="save()" :disabled="loading">
                    {{post.id ? 'Atualizar' : 'Cadastrar'}}
                </b-button>
        </template>
    </b-modal>
</template>

<script>
    import MixinsGlobal from  '../../mixins/global-mixins'
    export default {
        props: ['selected', 'id'],
        mixins: [
            MixinsGlobal
        ],
        data() {
            return {
                instituicoes: [],
                titulacoes: [],
                loading: false,
                post: {
                    id: null,
                    numero_socio: null,
                    anuidade: null,
                    divisao_tematica: null,
                    obs_isentamos: null,
                    instituicao_id: null,
                    titulacao_id: null,
                    _method: 'post'
                }
            }
        },
        mounted() {
            axios.get(`${process.env.MIX_BASE_URL}/get/instituicoes`).then(res => {
                this.instituicoes = res.data;
            })

            axios.get(`${process.env.MIX_BASE_URL}/get/titulacoes`).then(res => {
                this.titulacoes = res.data;
            })
        },
        watch: {
            selected() {
                if(this.selected) {
                    this.post.id = this.selected.id
                    this.post.numero_socio = this.selected.numero_socio
                    this.post.anuidade = this.selected.anuidade
                    this.post.divisao_tematica = this.selected.divisao_tematica
                    this.post.instituicao_id = this.selected.instituicao_id
                    this.post.titulacao_id = this.selected.titulacao_id
                    this.post.obs_isentamos = this.selected.obs_isentamos
                    this.post._method = 'put'
                } else {
                    this.clear()
                }
            }
        },
        computed: {
            url() {
                return this.post && this.post.id ? `/${this.post.id}` : ''
            },
        },
        methods: {
            save() {
                this.$validator.validate().then((valid) => {
                    if(valid) {
                        this.message('Aguarde...', 'Estamos salvando suas informações', 'info', -1);
                        this.loading = true
                        axios.post(`${process.env.MIX_BASE_URL}/admin/associado${this.url}`, this.post).then(res => {
                            this.clear()
                            if(res.status == 201) {
                                this.loading = false
                                this.$emit('store', res.data.response)
                            } else {
                                this.loading = false
                                this.$emit('update', res.data.response)
                            }
                            this.message('Sucesso', res.status == 201 ? 'Registro cadastrado.' : 'Registro atualizado.', 'success');
                        }).catch(error => {
                            if(error.response.status == 422) {
                                if(error.response.data.message == "The given data was invalid.") {
                                    this.loading = false
                                    return this.message('Campos Obrigatórios', 'Preencha todos os campos obrigatórios', 'error');
                                }
                            }
                            if(error.response.status == 400) {
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
                    } else {
                        this.message('Campos Obrigatórios', 'Preencha todos os campos obrigatórios', 'error');
                    }
                })
            },
            clear() {
                this.post.id = null
                this.post.numero_socio = null 
                this.post.anuidade = null 
                this.post.divisao_tematica = null 
                this.post.instituicao_id = null 
                this.post.titulacao_id = null 
                this.post._method = 'post'
                this.$validator.reset('numero_socio')
                this.$validator.reset('associado')
                this.$validator.reset('anuidade')
                this.$validator.reset('divisao_tematica')
                this.$validator.reset('titulacao')
                this.$validator.reset('instituicao')
            }
        },
    }
</script>
