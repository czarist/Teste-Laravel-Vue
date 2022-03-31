<template>
    <b-modal id="modalAvaliador" size="lg" no-close-on-backdrop>
        <template #modal-header="{ close }">
            <h5>Dados do Trabalho</h5>
            <b-button size="sm" variant="outline-danger" @click="close()">X</b-button>
        </template>
        <template>
            <div class="text-center"><h6>Parecer e resultado da avaliação</h6></div>
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
                            name="status_avaliador"
                            v-validate="{ required: true }"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`status_avaliador`)}]"
                            size="sm"
                            data-vv-as="Status"
                            class="form-control form-control-sm"
                            v-model="post.status_avaliador"
                        >
                        <option :value="null">Selecione</option>
                        <option v-for="status in statuses" :value="status.value" :key="status.value">
                            {{ status.text }}
                        </option>
                        </b-form-select>


                        <span v-show="errors.has(`status_avaliador`)" class="invalid-feedback d-block">
                            {{ errors.first(`status_avaliador`) }}
                        </span>
                    </b-form-group>
                </b-col>

                <b-col cols="12" sm="6" lg="12" class="text-center">
                    <b-form-group label="Justificativa do Avaliador" style="font-size:20px !important; color:black;">
                            <textarea 
                                rows="8"
                                class="form-control" 
                                v-model="post.justificativa_avaliador" 
                                name="justificativa_avaliador"
                                :class="['form-control form-control-sm', {'is-invalid': errors.has(`justificativa_avaliador`)}]"
                            ></textarea>
                        <span v-show="errors.has(`justificativa_avaliador`)" class="invalid-feedback">
                            {{ errors.first(`justificativa_avaliador`) }}
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
        props: ['selectedAvaliador', 'id'],
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
            selectedAvaliador() {
                if(this.selectedAvaliador) {
                    this.$forceUpdate()
                    this.post.id = this.selectedAvaliador && this.selectedAvaliador.avaliacao ? this.selectedAvaliador.avaliacao.id : null
                    this.post.inscricao_id = this.selectedAvaliador ? this.selectedAvaliador.inscricao_id : null
                    this.post.submissao_id = this.selectedAvaliador ? this.selectedAvaliador.id : null
                    this.post.regiao = this.selectedAvaliador ? this.selectedAvaliador.regiao : null
                    this.post.titulo = this.selectedAvaliador ? this.selectedAvaliador.titulo : null
                    this.post.dt = this.selectedAvaliador ? this.selectedAvaliador.dt : null
                    this.post.justificativa_avaliador = this.selectedAvaliador && this.selectedAvaliador.avaliacao ? this.selectedAvaliador.avaliacao.justificativa_avaliador : null
                    this.post.status_avaliador = this.selectedAvaliador && this.selectedAvaliador.avaliacao ? this.selectedAvaliador.avaliacao.status_avaliador : null        
                    this.post.avaliacao = this.selectedAvaliador && this.selectedAvaliador.avaliacao ? this.selectedAvaliador.avaliacao : null
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
                                axios.post(`${process.env.MIX_BASE_URL}/avaliacao/avaliador/save`, this.post).then( res => {
                                    
                                    this.clear()
                                    if(res.status == 201) {
                                        this.loading = false
                                        this.$emit('store', res.data.response)
                                    } else {
                                        this.loading = false
                                        this.$emit('update', res.data.response)
                                    }
                                    this.message('Sucesso', res.status == 201 ? 'Usuário cadastrado.' : 'Usuário atualizado.', 'success');
                                    
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