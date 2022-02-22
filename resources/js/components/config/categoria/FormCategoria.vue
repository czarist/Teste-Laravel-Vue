<template>
    <b-modal id="categoriaModal" no-close-on-backdrop>
        <template #modal-header="{ close }">
            <h5 v-if="post.id">Editar categoria</h5>
            <h5 v-else>Cadastrar categoria</h5>
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
                            v-validate="{ required: true   }"
                            aria-describedby="input-1-live-feedback"
                            data-vv-as="número sócio"
                        ></b-form-input>
                        <span v-show="errors.has(`numero_socio`)" class="invalid-feedback">
                            {{ errors.first(`numero_socio`) }}
                        </span>
                    </b-form-group>
                </b-col>

                <b-col>
                    <b-form-group label="Categoria" label-class="font-weight-bold" cols="12" sm="6" lg="4">
                        <b-form-input
                            name="categoria"
                            size="sm"
                            v-model="post.categoria"
                            type="text"
                            :disabled="loading"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`categoria`)}]"
                            v-validate="{ required: true }"
                            aria-describedby="input-1-live-feedback"
                            data-vv-as="categoria"
                        ></b-form-input>
                        <span v-show="errors.has(`categoria`)" class="invalid-feedback">
                            {{ errors.first(`categoria`) }}
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
                    <b-form-group label="Usuário" label-class="font-weight-bold">
                        <b-form-select
                            :disabled="loading"
                            name="usuario"
                            v-validate="{ required: true }"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`usuario`)}]"
                            size="sm"
                            class="form-control form-control-sm"
                            v-model="post.user_id"
                        >
                        <option :value="null">Selecione</option>
                        <option v-for="usuario in usuarios" :value="usuario.id" :key="usuario.id">
                            {{ usuario.name }}
                        </option>
                        </b-form-select>
                        <span v-show="errors.has(`usuario`)" class="invalid-feedback">
                            {{ errors.first(`usuario`) }}
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
                usuarios: [],
                loading: false,
                post: {
                    id: null,
                    numero_socio: null,
                    categoria: null,
                    anuidade: null,
                    divisao_tematica: null,
                    obs_isentamos: null,
                    user_id:null,
                    _method: 'post'
                }
            }
        },
        mounted() {
            axios.get(`${process.env.MIX_BASE_URL}/get/users`).then(res => {
                this.usuarios = res.data;
            })
        },
        watch: {
            selected() {
                if(this.selected) {
                    this.post.id = this.selected.id
                    this.post.numero_socio = this.selected.numero_socio
                    this.post.categoria = this.selected.categoria
                    this.post.anuidade = this.selected.anuidade
                    this.post.divisao_tematica = this.selected.divisao_tematica
                    this.post.user_id = this.selected.user_id
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
                        axios.post(`${process.env.MIX_BASE_URL}/config/categoria${this.url}`, this.post).then(res => {
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
                this.post.categoria = null 
                this.post.anuidade = null 
                this.post.divisao_tematica = null 
                this.post.user_id = null 
                this.post._method = 'post'
                this.$validator.reset('numero_socio')
                this.$validator.reset('categoria')
                this.$validator.reset('anuidade')
                this.$validator.reset('divisao_tematica')
                this.$validator.reset('usuario')

            }
        },
    }
</script>
