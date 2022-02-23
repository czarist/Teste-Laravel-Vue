<template>
    <b-modal id="instituicaoModal" no-close-on-backdrop>
        <template #modal-header="{ close }">
            <h5 v-if="post.id">Editar instituição</h5>
            <h5 v-else>Cadastrar instituição</h5>
            <b-button size="sm" variant="outline-danger" @click="close()">x</b-button>
        </template>
        <template>
            <b-form-group label="Instituição" label-class="font-weight-bold">
                <b-form-input
                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`instituicao`)}]"
                    name="instituicao"
                    size="sm"
                    v-model="post.instituicao"
                    type="text"
                    v-validate="{ required: true }"
                    aria-describedby="input-1-live-feedback"
                    data-vv-as="instituição"
                    :disabled="loading"
                ></b-form-input>
                <span v-show="errors.has(`instituicao`)" class="invalid-feedback">
                    {{ errors.first(`instituicao`) }}
                </span>
            </b-form-group>

            <b-form-group label="Sigla" label-class="font-weight-bold">
                <b-form-input
                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`instituicao`)}]"
                    name="sigla_instituicao"
                    size="sm"
                    v-model="post.sigla_instituicao"
                    type="text"
                    v-validate="{ required: true }"
                    aria-describedby="input-1-live-feedback"
                    data-vv-as="sigla da Instituição"
                    :disabled="loading"
                ></b-form-input>
                <span v-show="errors.has(`sigla_instituicao`)" class="invalid-feedback">
                    {{ errors.first(`sigla_instituicao`) }}
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
                    instituicao: null,
                    sigla_instituicao: null,
                    _method: 'post'
                }
            }
        },
        watch: {
            selected() {
                if(this.selected) {
                    this.post.id = this.selected.id
                    this.post.instituicao = this.selected.instituicao
                    this.post.sigla_instituicao = this.selected.sigla_instituicao
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
                        axios.post(`${process.env.MIX_BASE_URL}/admin/instituicao${this.url}`, this.post).then(res => {
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
                this.post.instituicao = null
                this.post.sigla_instituicao = null
                this.post._method = 'post'
                this.$validator.reset('instituicao')
                this.$validator.reset('sigla_instituicao')
            }
        },
    }
</script>
