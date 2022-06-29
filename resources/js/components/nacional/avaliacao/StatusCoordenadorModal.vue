<template>
    <b-modal id="modalCoordenador" size="lg" no-close-on-backdrop>
        <template #modal-header="{ close }">
            <h5>Dados do Trabalho</h5>
            <b-button size="sm" variant="outline-danger" @click="close()">X</b-button>
        </template>
        <template>
            <div class="text-center"><h6>Parecer e resultado do Coordenador</h6></div>
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
                    <b-form-group label="Status atual do trabalho:" label-class="font-weight-bold">
                        <b-form-select
                            :disabled="loading"
                            name="status_coordenador"
                            v-validate="{ required: true }"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`status_coordenador`)}]"
                            size="sm"
                            data-vv-as="Status"
                            class="form-control form-control-sm"
                            v-model="post.status_coordenador"
                        >
                        <option :value="null">Selecione</option>
                        <option v-for="status in statuses" :value="status.value" :key="status.value">
                            {{ status.text }}
                        </option>
                        </b-form-select>


                        <span v-show="errors.has(`status_coordenador`)" class="invalid-feedback d-block">
                            {{ errors.first(`status_coordenador`) }}
                        </span>
                    </b-form-group>
                </b-col>

                <b-col cols="12" sm="6" lg="12" class="text-center">
                    <b-form-group label="Justificativa do Coordenador" style="font-size:20px !important; color:black;">
                            <textarea 
                                rows="8"
                                class="form-control" 
                                v-model="post.justificativa_coordenador" 
                                name="justificativa_coordenador"
                                :class="['form-control form-control-sm', {'is-invalid': errors.has(`justificativa_coordenador`)}]"
                            ></textarea>
                        <span v-show="errors.has(`justificativa_coordenador`)" class="invalid-feedback">
                            {{ errors.first(`justificativa_coordenador`) }}
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
        props: ['selectedCoordenador', 'id'],
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
                statuses: null,
                post: {
                    id: null,
                    titulo: null,
                    dt: [],
                    inscricao_id: null,
                    regiao: null,
                    justificativa_coordenador: null,
                    status_coordenador: null,
                    _method: 'post'
                },
                statuses: [
                    { text: 'Em avaliação', value: "Em avaliação" },
                    { text: 'Aceito', value: "Aceito" },
                    { text: 'Alteração solicitada', value: "Alteração solicitada" },
                    { text: 'Recusado', value: "Recusado" }
                ],
            }
        },
        watch: {
            selectedCoordenador() {
                if(this.selectedCoordenador) {
                    this.$forceUpdate()
                    this.post.id = this.selectedCoordenador && this.selectedCoordenador.avaliacao ? this.selectedCoordenador.avaliacao.id : null
                    this.post.inscricao_id = this.selectedCoordenador ? this.selectedCoordenador.inscricao_id : null
                    this.post.submissao_id = this.selectedCoordenador ? this.selectedCoordenador.id : null
                    this.post.regiao = this.selectedCoordenador ? this.selectedCoordenador.regiao : null
                    this.post.titulo = this.selectedCoordenador ? this.selectedCoordenador.titulo : null
                    this.post.dt = this.selectedCoordenador ? this.selectedCoordenador.dt : null
                    this.post.justificativa_coordenador = this.selectedCoordenador && this.selectedCoordenador.avaliacao ? this.selectedCoordenador.avaliacao.justificativa_coordenador : null
                    this.post.status_coordenador = this.selectedCoordenador && this.selectedCoordenador.avaliacao ? this.selectedCoordenador.avaliacao.status_coordenador : null        
                    this.post.avaliacao = this.selectedCoordenador && this.selectedCoordenador.avaliacao ? this.selectedCoordenador.avaliacao : null
                    this.post._method = this.post && this.post.id ? 'post' : 'post'

                } else {
                    this.clear()
                }
            },
        },
        computed: {
            url() {
                return this.post && this.post.id ? `/${this.post.id}` : ''
            },

        },
        methods: {
            find_dt(post){
                if(post && this.tipo == "Grupo de Pesquisa"){
                    let selectedDt =  this.gps.find(gp => gp.id === post.dt)
                    let dt = selectedDt ? selectedDt.gp : ''
                    let dt_descricao = selectedDt ? selectedDt.descricao : ''
                    let returno = dt+' - '+dt_descricao
                    return returno ? returno : "NI"
                }

                if(post && this.tipo == "Intercom Júnior"){
                    let selectedDt =  this.divisoes_tematicas_jr.find(dt => dt.id === post.dt)
                    let dt = selectedDt ? selectedDt.dt : ''
                    let dt_descricao = selectedDt ? selectedDt.descricao : ''
                    let returno = dt+' - '+dt_descricao
                    return returno ? returno : "NI"
                }

                if(post && this.tipo == "Publicom"){
                    let selectedDt =  this.divisoes_tematicas.find(dt => dt.id === post.dt)
                    let dt = selectedDt ? selectedDt.dt : ''
                    let dt_descricao = selectedDt ? selectedDt.descricao : ''
                    let returno = dt+' - '+dt_descricao
                    return returno ? returno : "NI"
                }
            },    
            async save() {
                this.loading = true
                await this.$validator.validateAll().then((valid) => {
                    if(valid) {
                        this.message('Aguarde...', 'Estamos salvando suas informações', 'info', -1);

                        setTimeout(() => {
                            axios.post(`${process.env.MIX_BASE_URL}/avaliacao_nacional/coordenador/save`, this.post).then( res => {
                                
                                this.clear()
                                if(res.status == 201) {
                                    this.loading = false
                                    this.$emit('store', res.data.response)
                                } else {
                                    this.loading = false
                                    this.$emit('update', res.data.response)
                                }
                                this.message('Sucesso', res.status == 201 ? 'Usuário cadastrado.' : 'Usuário atualizado.', 'success');
                                
                                this.$bvModal.hide('modalCoordenador')

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
            clear() {
                this.post.id = null
                this.post.name = null
                this.post._method = 'post'
                this.$validator.reset('name')
            }
        },
        created() {
        },

    }
</script>

<style scoped>
    ::v-deep .modal-backdrop {
        opacity: 0.5 !important;
    }
</style>