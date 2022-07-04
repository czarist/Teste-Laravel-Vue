<template>
    <b-modal id="modalAvaliador" size="lg" no-close-on-backdrop>
        <template #modal-header="{ close }">
            <h5>Dados do Trabalho</h5>
            <b-button size="sm" variant="outline-danger" @click="close()">X</b-button>
        </template>
        <template>
            <div class="text-center font-weight-bold m-3" style="color:black;"><h6>Parecer e resultado da avaliação</h6></div>
            <b-row>
                <b-col cols="12" sm="6" lg="6">
                    <b-form-group label="Inscrição/Trabalho" label-class="font-weight-bold" style="color:black;">
                        {{ post ? post.submissao_id : '' }} / {{ post ? post.inscricao_id : '' }}
                    </b-form-group>
                </b-col>

                <b-col cols="12" sm="6" lg="6">
                    <b-form-group label="Área" label-class="font-weight-bold" style="color:black;">
                        {{ find_dt(post) }}
                    </b-form-group>                
                </b-col>

                <b-col cols="12" sm="12" lg="12" class="mt-3">
                    <b-form-group label="Título" label-class="font-weight-bold" style="color:black;">
                        {{ post ? post.titulo : '' }}
                    </b-form-group>
                </b-col>

                <b-col cols="12" sm="12" lg="12" class="mt-3" v-if="tipo && tipo == 'Grupo de Pesquisa'">
                    <b-card>
                        <b-form-group label="1 - O texto está no modelo-padrão do congresso?" v-slot="{ pergunta_1 }" style="color:black;">
                            <b-form-radio-group
                                id="radio-group-1"
                                v-model="post.pergunta_1"
                                :options="options"
                                :aria-describedby="pergunta_1"
                                name="radio-options1"
                                :class="['form-control form-control-sm', {'is-invalid': errors.has(`radio-options1`)}]" 
                                v-validate="{ required: true }"
                            ></b-form-radio-group>
                            <span v-show="errors.has(`radio-options1`)" class="invalid-feedback d-block text-danger">
                                <div class="text-danger">Selecione sim ou não</div>
                            </span>
                        </b-form-group>
                    </b-card>
                </b-col>

                <b-col cols="12" sm="12" lg="12" class="mt-3" v-if="tipo && tipo == 'Grupo de Pesquisa'">
                    <b-card>
                        <b-form-group label="2 - O texto tem entre 10 e 15 páginas?" v-slot="{ pergunta_2 }" style="color:black;">
                            <b-form-radio-group
                                id="radio-group-2"
                                v-model="post.pergunta_2"
                                :options="options"
                                :aria-describedby="pergunta_2"
                                name="radio-options2"
                                :class="['form-control form-control-sm', {'is-invalid': errors.has(`radio-options2`)}]" 
                                v-validate="{ required: true }"
                            ></b-form-radio-group>
                            <span v-show="errors.has(`radio-options2`)" class="invalid-feedback d-block text-danger">
                                <div class="text-danger">Selecione sim ou não</div>
                            </span>
                        </b-form-group>
                    </b-card>
                </b-col>

                <b-col cols="12" sm="12" lg="12" class="mt-3" v-if="tipo && tipo == 'Grupo de Pesquisa'">
                    <b-card>
                        <b-form-group label="3 - O texto apresenta, no início, título, nome do(s) autor(es), instituição a que pertence(m), um resumo de até 10 linhas e palavras-chave?" v-slot="{ pergunta_3 }" style="color:black;">
                            <b-form-radio-group
                                id="radio-group-3"
                                v-model="post.pergunta_3"
                                :options="options"
                                :aria-describedby="pergunta_3"
                                name="radio-options3"
                                :class="['form-control form-control-sm', {'is-invalid': errors.has(`radio-options3`)}]" 
                                v-validate="{ required: true }"
                            ></b-form-radio-group>
                            <span v-show="errors.has(`radio-options3`)" class="invalid-feedback d-block text-danger">
                                <div class="text-danger">Selecione sim ou não</div>
                            </span>
                        </b-form-group>
                    </b-card>
                </b-col>

                <b-col cols="12" sm="12" lg="12" class="mt-3" v-if="tipo && tipo == 'Grupo de Pesquisa'">
                    <b-card>
                        <b-form-group label="4 - O texto apresenta a primeira nota de rodapé de acordo com a formataçao exigida no padrão do congresso?" v-slot="{ pergunta_4 }" style="color:black;">
                            <b-form-radio-group
                                id="radio-group-4"
                                v-model="post.pergunta_4"
                                :options="options"
                                :aria-describedby="pergunta_4"
                                name="radio-options4"
                                :class="['form-control form-control-sm', {'is-invalid': errors.has(`radio-options4`)}]" 
                                v-validate="{ required: true }"
                            ></b-form-radio-group>
                            <span v-show="errors.has(`radio-options4`)" class="invalid-feedback d-block text-danger">
                                <div class="text-danger">Selecione sim ou não</div>
                            </span>
                        </b-form-group>
                    </b-card>
                </b-col>

                <b-col cols="12" sm="12" lg="12" class="mt-3" v-if="tipo && tipo == 'Grupo de Pesquisa'">
                    <b-card>
                        <b-form-group label="5 - Ao final do texto é apresentada a bibliografia de referência?" v-slot="{ pergunta_5 }" style="color:black;">
                            <b-form-radio-group
                                id="radio-group-5"
                                v-model="post.pergunta_5"
                                :options="options"
                                :aria-describedby="pergunta_5"
                                name="radio-options5"
                                :class="['form-control form-control-sm', {'is-invalid': errors.has(`radio-options5`)}]" 
                                v-validate="{ required: true }"
                            ></b-form-radio-group>
                            <span v-show="errors.has(`radio-options5`)" class="invalid-feedback d-block text-danger">
                                <div class="text-danger">Selecione sim ou não</div>
                            </span>
                        </b-form-group>
                    </b-card>
                </b-col>

                <b-col cols="12" sm="12" lg="12" class="mt-3" v-if="tipo && tipo == 'Grupo de Pesquisa'">
                    <b-card>
                        <b-form-group label="6 - O texto está rigorosamente dentro das exigências acadêmicas: solidez teórica, relevância do tema, correção textual e normas técnicas ABNT?" v-slot="{ pergunta_6 }" style="color:black;">
                            <b-form-radio-group
                                id="radio-group-6"
                                v-model="post.pergunta_6"
                                :options="options"
                                :aria-describedby="pergunta_6"
                                name="radio-options6"
                                :class="['form-control form-control-sm', {'is-invalid': errors.has(`radio-options6`)}]"                                
                                v-validate="{ required: true }"
                            ></b-form-radio-group>
                            <span v-show="errors.has(`radio-options6`)" class="invalid-feedback d-block text-danger">
                                <div class="text-danger">Selecione sim ou não</div>
                            </span>
                        </b-form-group>
                    </b-card>
                </b-col>

                <b-col cols="12" sm="12" lg="12" class="mt-3" v-if="tipo && tipo == 'Grupo de Pesquisa'">
                    <b-card>
                        <b-form-group label="7 - O texto apresenta contribuição resultante de pesquisa científica?" v-slot="{ pergunta_7 }" style="color:black;">
                            <b-form-radio-group
                                id="radio-group-7"
                                v-model="post.pergunta_7"
                                :options="options"
                                :aria-describedby="pergunta_7"
                                name="radio-options7"
                                :class="['form-control form-control-sm', {'is-invalid': errors.has(`radio-options7`)}]"
                                v-validate="{ required: true }"
                            ></b-form-radio-group>
                            <span v-show="errors.has(`radio-options7`)" class="invalid-feedback d-block text-danger">
                                <div class="text-danger">Selecione sim ou não</div>
                            </span>
                        </b-form-group>
                    </b-card>
                </b-col>

                <b-col cols="12" sm="12" lg="12" class="mt-3" v-if="tipo && tipo == 'Grupo de Pesquisa'">
                    <b-card>
                        <b-form-group label="8 - O texto é pertinente a ementa do GP?" v-slot="{ pergunta_8 }" style="color:black;">
                            <b-form-radio-group
                                id="radio-group-8"
                                v-model="post.pergunta_8"
                                :options="options"
                                :aria-describedby="pergunta_8"
                                name="radio-options8"
                                :class="['form-control form-control-sm', {'is-invalid': errors.has(`radio-options8`)}]"
                                v-validate="{ required: true }"
                            ></b-form-radio-group>
                            <span v-show="errors.has(`radio-options8`)" class="invalid-feedback d-block text-danger">
                                <div class="text-danger">Selecione sim ou não</div>
                            </span>
                        </b-form-group>
                    </b-card>
                </b-col>

                <b-col cols="12" sm="12" lg="12" class="mt-3" v-if="tipo && tipo == 'Grupo de Pesquisa'">
                    <b-card>
                        <b-form-group label="9 - Os objetivos do texto estão bem definidos?" v-slot="{ pergunta_9 }" style="color:black;">
                            <b-form-radio-group
                                id="radio-group-9"
                                v-model="post.pergunta_9"
                                :options="options"
                                :aria-describedby="pergunta_9"
                                name="radio-options9"
                                :class="['form-control form-control-sm', {'is-invalid': errors.has(`radio-options9`)}]"
                                v-validate="{ required: true }"
                            ></b-form-radio-group>
                            <span v-show="errors.has(`radio-options9`)" class="invalid-feedback d-block text-danger">
                                <div class="text-danger">Selecione sim ou não</div>
                            </span>
                        </b-form-group>
                    </b-card>
                </b-col>

                <b-col cols="12" sm="12" lg="12" class="mt-3" v-if="tipo && tipo == 'Grupo de Pesquisa'">
                    <b-card>
                        <b-form-group label="10 - O texto apresenta fundamentação teórica adequada e atualizada?" v-slot="{ pergunta_10 }" style="color:black;">
                            <b-form-radio-group
                                id="radio-group-10"
                                v-model="post.pergunta_10"
                                :options="options"
                                :aria-describedby="pergunta_10"
                                name="radio-options10"
                                :class="['form-control form-control-sm', {'is-invalid': errors.has(`radio-options10`)}]"
                                v-validate="{ required: true }"
                            ></b-form-radio-group>
                            <span v-show="errors.has(`radio-options10`)" class="invalid-feedback d-block text-danger">
                                <div class="text-danger">Selecione sim ou não</div>
                            </span>
                        </b-form-group>
                    </b-card>
                </b-col>

                <b-col cols="12" sm="12" lg="12" class="mt-3" v-if="tipo && tipo == 'Grupo de Pesquisa'">
                    <b-card>
                        <b-form-group label="11 - O texto está metodicamente organizado?" v-slot="{ pergunta_11 }" style="color:black;">
                            <b-form-radio-group
                                id="radio-group-11"
                                v-model="post.pergunta_11"
                                :options="options"
                                :aria-describedby="pergunta_11"
                                name="radio-options11"
                                v-validate="{ required: true }"
                                :class="['form-control form-control-sm', {'is-invalid': errors.has(`radio-options11`)}]"
                            ></b-form-radio-group>
                            <span v-show="errors.has(`radio-options11`)" class="invalid-feedback d-block text-danger">
                                <div class="text-danger"><div class="text-danger">Selecione sim ou não</div></div>
                            </span>
                        </b-form-group>
                    </b-card>
                </b-col>

                <b-col cols="12" sm="12" lg="12" class="mt-3" v-if="tipo && tipo == 'Grupo de Pesquisa'">
                    <b-card title="Orientação">
                        <b-card-text>
                            - Respostas SIM para todas as questões: ACEITO <br>

                            - Respostas NÃO para uma ou mais questões: ACEITO COM ALTERAÇÕES<br>

                            - Respostas NÃO para a maior parte das inscrições: RECUSADO<br>
                        </b-card-text>
                    </b-card>
                </b-col>


                <b-col cols="12" sm="12" lg="12" class="mt-3">
                    <b-form-group label="Status atual do trabalho:" label-class="font-weight-bold" style="font-size:20px !important; color:black;" class="text-center">
                        <b-form-select
                            :disabled="loading"
                            name="status_avaliador"
                            v-validate="{ required: true }"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`status_avaliador`)}]"
                            size="sm"
                            data-vv-as="Status"
                            class="form-control form-control-sm"
                            style="color:black;"
                            v-model="post.status_avaliador"
                        >
                        <option :value="null">Selecione</option>
                        <option v-for="status in statuses" :value="status.value" :key="status.value">
                            {{ status.text }}
                        </option>
                        </b-form-select>
                        <span v-show="errors.has(`status_avaliador`)" class="invalid-feedback d-block text-danger">
                            {{ errors.first(`status_avaliador`) }}
                        </span>
                    </b-form-group>
                </b-col>

                <b-col cols="12" sm="6" lg="12" class="text-center">
                    <b-form-group label="Justificativa do Avaliador" label-class="font-weight-bold" style="font-size:20px !important; color:black;">
                            <textarea 
                                rows="8"
                                class="form-control" 
                                v-model="post.justificativa_avaliador" 
                                name="justificativa_avaliador"
                                :class="['form-control form-control-sm']"
                            ></textarea>
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
        props: ['selectedAvaliador', 'user', 'divisoes_tematicas', 'divisoes_tematicas_jr', 'gps'],
        mixins: [
            MixinsGlobal
        ],
        data() {
            return {
                baseUrl: process.env.MIX_BASE_URL,
                loading: false,
                verify: null,
                avaliadores: [],
                tipo: null,
                post: {
                    id: null,
                    titulo: null,
                    dt: [],
                    inscricao_id: null,
                    pergunta_1: null,
                    pergunta_2: null,
                    pergunta_3: null,
                    pergunta_4: null,
                    pergunta_5: null,
                    pergunta_6: null,
                    pergunta_7: null,
                    pergunta_8: null,
                    pergunta_9: null,
                    pergunta_10: null,
                    pergunta_11: null,
                    _method: 'post'
                },
                statuses: [
                    { text: 'Em avaliação', value: "Em avaliação" },
                    { text: 'Aceito', value: "Aceito" },
                    { text: 'Alteração solicitada', value: "Alteração solicitada" },
                    { text: 'Recusado', value: "Recusado" }
                ],
                options: [
                    { text: 'Sim', value: 1},
                    { text: 'Não', value: 0}
                ]
            }
        },
        watch: {
            selectedAvaliador() {
                if(this.selectedAvaliador) {
                    this.$forceUpdate()
                    this.post.id = this.selectedAvaliador ? this.selectedAvaliador.id : null
                    this.post.inscricao_id = this.selectedAvaliador && this.selectedAvaliador.submissao ? this.selectedAvaliador.submissao.inscricao_id : null
                    this.post.submissao_id = this.selectedAvaliador ? this.selectedAvaliador.id : null
                    this.post.titulo = this.selectedAvaliador && this.selectedAvaliador.submissao ? this.selectedAvaliador.submissao.titulo : null
                    this.post.dt = this.selectedAvaliador && this.selectedAvaliador.submissao ? this.selectedAvaliador.submissao.dt : null
                    this.tipo = this.selectedAvaliador && this.selectedAvaliador.submissao ? this.selectedAvaliador.submissao.tipo : null               
                    if(this.selectedAvaliador && this.selectedAvaliador.avaliador_1 == this.user.id ){
                        this.post.justificativa_avaliador = this.selectedAvaliador ? this.selectedAvaliador.justificativa_avaliador_1 : null
                        this.post.status_avaliador = this.selectedAvaliador ? this.selectedAvaliador.status_avaliador_1 : null    
                        this.post.pergunta_1 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_1_1 : null    
                        this.post.pergunta_2 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_1_2 : null    
                        this.post.pergunta_3 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_1_3 : null    
                        this.post.pergunta_4 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_1_4 : null    
                        this.post.pergunta_5 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_1_5 : null    
                        this.post.pergunta_6 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_1_6 : null    
                        this.post.pergunta_7 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_1_7 : null    
                        this.post.pergunta_8 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_1_8 : null    
                        this.post.pergunta_9 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_1_9 : null    
                        this.post.pergunta_10 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_1_10 : null    
                        this.post.pergunta_11 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_1_11 : null    
                    }
                    if(this.selectedAvaliador && this.selectedAvaliador.avaliador_2 == this.user.id ){
                        this.post.justificativa_avaliador = this.selectedAvaliador ? this.selectedAvaliador.justificativa_avaliador_2 : null
                        this.post.status_avaliador = this.selectedAvaliador ? this.selectedAvaliador.status_avaliador_2 : null  
                        this.post.pergunta_1 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_2_1 : null    
                        this.post.pergunta_2 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_2_2 : null    
                        this.post.pergunta_3 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_2_3 : null    
                        this.post.pergunta_4 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_2_4 : null    
                        this.post.pergunta_5 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_2_5 : null    
                        this.post.pergunta_6 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_2_6 : null    
                        this.post.pergunta_7 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_2_7 : null    
                        this.post.pergunta_8 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_2_8 : null    
                        this.post.pergunta_9 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_2_9 : null    
                        this.post.pergunta_10 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_2_10 : null    
                        this.post.pergunta_11 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_2_11 : null    

                    }
                    if(this.selectedAvaliador && this.selectedAvaliador.avaliador_3 == this.user.id ){
                        this.post.justificativa_avaliador = this.selectedAvaliador ? this.selectedAvaliador.justificativa_avaliador_3 : null
                        this.post.status_avaliador = this.selectedAvaliador ? this.selectedAvaliador.status_avaliador_3 : null    
                        this.post.pergunta_1 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_3_1 : null    
                        this.post.pergunta_2 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_3_2 : null    
                        this.post.pergunta_3 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_3_3 : null    
                        this.post.pergunta_4 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_3_4 : null    
                        this.post.pergunta_5 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_3_5 : null    
                        this.post.pergunta_6 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_3_6 : null    
                        this.post.pergunta_7 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_3_7 : null    
                        this.post.pergunta_8 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_3_8 : null    
                        this.post.pergunta_9 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_3_9 : null    
                        this.post.pergunta_10 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_3_10 : null    
                        this.post.pergunta_11 = this.selectedAvaliador ? this.selectedAvaliador.pergunta_3_11 : null    
                    }

                    this.post.submissao = this.selectedAvaliador && this.selectedAvaliador.submissao ? this.selectedAvaliador.submissao : null
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
                if(this.post.dt.length > 1){
                    this.message('Erro', 'Selecione uma divisão temática apenas!', 'error');
                    this.loading = false
                    return

                }else{
                    await this.$validator.validateAll().then((valid) => {
                        if(valid) {
                            this.message('Aguarde...', 'Estamos salvando suas informações', 'info', -1);

                            setTimeout(() => {
                                axios.post(`${process.env.MIX_BASE_URL}/avaliacao_nacional/avaliador/save`, this.post).then( res => {
                                    
                                    this.clear()
                                    
                                    this.message('Sucesso', res.status == 201 ? 'Usuário cadastrado.' : 'Usuário atualizado.', 'success');

                                    window.location.reload()

                                    this.$bvModal.hide('modalAvaliador')

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

    ::v-deep span {
        color:black !important;
    }

</style>