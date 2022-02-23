<template>
    <b-modal id="titulacaoModal" no-close-on-backdrop>
        <template #modal-header="{ close }">
            <h5 v-if="post.id">Editar titulação</h5>
            <h5 v-else>Cadastrar titulação</h5>
            <b-button size="sm" variant="outline-danger" @click="close()">x</b-button>
        </template>
        <template>
            <b-form-group label="Titulação" label-class="font-weight-bold">
                <b-form-input
                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`titulacao`)}]"
                    name="titulacao"
                    size="sm"
                    v-model="post.titulacao"
                    type="text"
                    v-validate="{ required: true }"
                    aria-describedby="input-1-live-feedback"
                    data-vv-as="titulação"
                    :disabled="loading"
                ></b-form-input>
                <span v-show="errors.has(`titulacao`)" class="invalid-feedback">
                    {{ errors.first(`titulacao`) }}
                </span>
            </b-form-group>
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
                loading: false,
                post: {
                    id: null,
                    titulacao: null,
                    _method: 'post'
                }
            }
        },
        watch: {
            selected() {
                if(this.selected) {
                    this.post.id = this.selected.id
                    this.post.titulacao = this.selected.titulacao
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
                        axios.post(`${process.env.MIX_BASE_URL}/admin/titulacao${this.url}`, this.post).then(res => {
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
                this.post.tipo_titulacao = null
                this.post._method = 'post'
                this.$validator.reset('tipo_titulacao')
            }
        },
    }
</script>
