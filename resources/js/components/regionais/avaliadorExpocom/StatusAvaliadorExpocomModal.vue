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

                <b-col cols="12" sm="12" lg="12">
                    <div class="text-center"><h6>Parecer e resultado da avaliação</h6></div>
                </b-col>

                <b-col cols="12" sm="12" lg="12">

                    <b-row>

                        <b-col cols="6" sm="6" lg="6">
                            <b-form-group label="O experimentalismo" label-class="font-weight-bold">
                                <b-form-select
                                    :disabled="loading"
                                    name="expe"
                                    v-validate="{ required: true }"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`expe`)}]"
                                    size="sm"
                                    data-vv-as="Experimentalismo"
                                    class="form-control form-control-sm"
                                    v-model="post.expe"
                                >
                                <option :value="null">Selecione</option>
                                <option v-for="ponto in pontos" :value="ponto.value" :key="ponto.value">
                                    {{ ponto.text }}
                                </option>
                                </b-form-select>
                            </b-form-group>                
                        </b-col>

                        <b-col cols="6" sm="6" lg="6">
                            <b-form-group label="A qualidade técnica do produto" label-class="font-weight-bold">
                                <b-form-select
                                    :disabled="loading"
                                    name="qualidade"
                                    v-validate="{ required: true }"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`qualidade`)}]"
                                    size="sm"
                                    data-vv-as="Qualidade"
                                    class="form-control form-control-sm"
                                    v-model="post.qualidade"
                                >
                                <option :value="null">Selecione</option>
                                <option v-for="ponto in pontos" :value="ponto.value" :key="ponto.value">
                                    {{ ponto.text }}
                                </option>
                                </b-form-select>
                            </b-form-group>                
                        </b-col>

                        <b-col cols="6" sm="6" lg="6">
                            <b-form-group label="A consistência teórica e coerência do conteúdo inserido no relatório com o respectivo do produto" label-class="font-weight-bold">
                                <b-form-select
                                    :disabled="loading"
                                    name="coerencia"
                                    v-validate="{ required: true }"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`coerencia`)}]"
                                    size="sm"
                                    data-vv-as="Consistência"
                                    class="form-control form-control-sm"
                                    v-model="post.coerencia"
                                >
                                <option :value="null">Selecione</option>
                                <option v-for="ponto in pontos" :value="ponto.value" :key="ponto.value">
                                    {{ ponto.text }}
                                </option>
                                </b-form-select>
                            </b-form-group>                
                        </b-col>

                        <b-col cols="6" sm="6" lg="6">
                            <b-form-group label="Média" label-class="font-weight-bold">
                                {{ calc_media(post) }}
                            </b-form-group>                
                        </b-col>
                    </b-row>
                </b-col>

                <b-col cols="12" sm="12" lg="12" class="text-center">
                    <b-form-group label="Justificativa do Avaliador" style="font-size:20px !important; color:black;">
                            <textarea 
                                rows="8"
                                class="form-control"
                                v-on:keyup="liveCountDown" 
                                v-model="post.justificativa_avaliador" 
                                name="justificativa_avaliador"
                                v-validate="{ required: true }"
                                :class="['form-control form-control-sm', {'is-invalid': errors.has(`justificativa_avaliador`)}]"
                            ></textarea>

                            <p>Total caracteres restante: <span v-bind:class="{'text-danger': generateErr }">{{totalRemainCount}}</span></p>

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
        props: ['selectedAvaliador', 'id', 'user'],
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
                limitmaxCount: 100,
                totalRemainCount: 100,
                generateErr: false,
                post: {
                    id: null,
                    titulo: null,
                    dt: [],
                    inscricao_id: null,
                    regiao: null,
                    coerencia: null,
                    expe: null,
                    justificativa_avaliador: null,
                    status_avaliador: null,
                    media: null,
                    qualidade: null,
                    submissao_id: null,
                    _method: 'post',


                },
                pontos: [
                    { text: "0.5", value: 0.5 },
                    { text: "1", value: 1 },
                    { text: "1.5", value: 1.5 },
                    { text: "2", value: 2 },
                    { text: "2.5", value: 2.5 },
                    { text: "3", value: 3 },
                    { text: "3.5", value: 3.5 },
                    { text: "4", value: 4 },
                    { text: "4.5", value: 4.5 },
                    { text: "5", value: 5 },
                    { text: "5.5", value: 5.5 },
                    { text: "6", value: 6 },
                    { text: "6.5", value: 6.5 },
                    { text: "7", value: 7 },
                    { text: "7.5", value: 7.5 },
                    { text: "8", value: 8 },
                    { text: "8.5", value: 8.5 },
                    { text: "9", value: 9 },
                    { text: "9.5", value: 9.5 },
                    { text: "10", value: 10 },
                ],
            }
        },
        watch: {
            selectedAvaliador() {
                if(this.selectedAvaliador) {
                    this.$forceUpdate()
                    this.post.id = this.selectedAvaliador ? this.selectedAvaliador.id : null
                    this.post.inscricao_id = this.selectedAvaliador && this.selectedAvaliador.submissao ? this.selectedAvaliador.submissao.inscricao_id : null
                    this.post.submissao_id = this.selectedAvaliador && this.selectedAvaliador.submissao ? this.selectedAvaliador.submissao.id : null

                    this.post.regiao = this.selectedAvaliador && this.selectedAvaliador.submissao ? this.selectedAvaliador.submissao.regiao : null
                    this.post.titulo = this.selectedAvaliador && this.selectedAvaliador.submissao && this.selectedAvaliador.submissao.inscricao && this.selectedAvaliador.submissao.inscricao.user && this.selectedAvaliador.submissao.inscricao.user.indicacao ? this.selectedAvaliador.submissao.inscricao.user.indicacao.titulo_trabalho.substring(40, 0) : null
                    this.post.dt = this.selectedAvaliador && this.selectedAvaliador.submissao && this.selectedAvaliador.submissao.inscricao && this.selectedAvaliador.submissao.inscricao.user && this.selectedAvaliador.submissao.inscricao.user.indicacao  ? this.selectedAvaliador.submissao.inscricao.user.indicacao.categoria : null            
                                        
                    if(this.selectedAvaliador && this.selectedAvaliador.avaliador_1 == this.user.id ){
                        this.post.justificativa_avaliador = this.selectedAvaliador ? this.selectedAvaliador.justificativa_avaliador_1 : null
                        this.post.status_avaliador = this.selectedAvaliador ? this.selectedAvaliador.status_avaliador_1 : null    

                        this.post.coerencia = this.selectedAvaliador ? parseFloat(this.selectedAvaliador.coerencia_1) : null
                        this.post.expe = this.selectedAvaliador ? parseFloat(this.selectedAvaliador.expe_1) : null
                        this.post.media = this.selectedAvaliador ? parseFloat(this.selectedAvaliador.media_1) : null
                        this.post.qualidade = this.selectedAvaliador ? parseFloat(this.selectedAvaliador.qualidade_1) : null

                    }
                    if(this.selectedAvaliador && this.selectedAvaliador.avaliador_2 == this.user.id ){
                        this.post.justificativa_avaliador = this.selectedAvaliador ? this.selectedAvaliador.justificativa_avaliador_2 : null
                        this.post.status_avaliador = this.selectedAvaliador ? this.selectedAvaliador.status_avaliador_2 : null
                        
                        this.post.coerencia = this.selectedAvaliador ? parseFloat(this.selectedAvaliador.coerencia_2) : null
                        this.post.expe = this.selectedAvaliador ? parseFloat(this.selectedAvaliador.expe_2) : null
                        this.post.media = this.selectedAvaliador ? parseFloat(this.selectedAvaliador.media_2) : null
                        this.post.qualidade = this.selectedAvaliador ? parseFloat(this.selectedAvaliador.qualidade_2) : null
                    }
                    if(this.selectedAvaliador && this.selectedAvaliador.avaliador_3 == this.user.id ){
                        this.post.justificativa_avaliador = this.selectedAvaliador ? this.selectedAvaliador.justificativa_avaliador_3 : null
                        this.post.status_avaliador = this.selectedAvaliador ? this.selectedAvaliador.status_avaliador_3 : null    

                        this.post.coerencia = this.selectedAvaliador ? parseFloat(this.selectedAvaliador.coerencia_3) : null
                        this.post.expe = this.selectedAvaliador ? parseFloat(this.selectedAvaliador.expe_3) : null
                        this.post.media = this.selectedAvaliador ? parseFloat(this.selectedAvaliador.media_3) : null
                        this.post.qualidade = this.selectedAvaliador ? parseFloat(this.selectedAvaliador.qualidade_3) : null
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
            liveCountDown: function() {
                this.totalRemainCount = this.limitmaxCount - this.post.justificativa_avaliador.length;
                this.generateErr = this.totalRemainCount > 0;
            },
            calc_media(post){
                if(post){
                    post.media = (post.coerencia + post.expe + post.qualidade) / 3

                    return post.media.toString().substring(3, 0)
                }
            },
            find_dt(post){
                // if(post && post.dt){
                //     let selectedDt =  this.divisoes_tematicas.find(dt => dt.id == post.dt)
                //     return selectedDt ? selectedDt.descricao : "NI"
                // }

                return post.dt
            },    
            async save() {
                this.loading = true
                await this.$validator.validateAll().then((valid) => {
                    if(valid) {
                        if(this.generateErr == true){

                            this.message('Limite minimo não alcançado ', 'Limite de 100 caracteres não alcançado!', 'error');

                            this.loading = false
                            return

                        } else{

                            this.message('Aguarde...', 'Estamos salvando suas informações', 'info', -1);

                            setTimeout(() => {
                                axios.post(`${process.env.MIX_BASE_URL}/avaliacaoexpocom/avaliador/save`, this.post).then( res => {
                                    
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
                            },1000);
                        }
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