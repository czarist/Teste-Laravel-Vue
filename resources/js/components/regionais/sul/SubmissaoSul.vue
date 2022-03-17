<template>

<div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <h1>SUBMISSÃO DE TRABALHO</h1>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header text-center">
                    <h2>DIVISÃO TEMÁTICA (DT)</h2>
                </div>

                <div class="card-body">
                    <b-row>
                        <div class="col-12  text-center">
                            <label for="ativo" label-class="font-weight-bold" style="font-size:20px !important; color:black;">CLIQUE NOS BOTÕES E ESCOLHA DIVISÕES TEMÁTICAS:</label><br />
                            <div class="switch-field-one">
                                <span v-for="(divisoes_tematica, index) in divisoes_tematicas" :key="index">
                                    <input
                                        :disabled="loading"
                                        :id="`dv_${index}`"
                                        name="divisoes_tematicas"
                                        type="checkbox"
                                        :class="[ 'form-control radio-inline radio_lista radio',{ 'is-invalid': errors.has(`divisoes_tematicas`) }]"                                        
                                        aria-describedby="input-1-live-feedback"
                                        data-vv-as="DIVISÃO TEMÁTICA"
                                        :value="divisoes_tematica.id"
                                        v-model="post.divisoes_tematicas"
                                    ><label :key="`label_${index}`" :for="`dv_${index}`" class="mr-2">{{ divisoes_tematica.dt }} - {{ divisoes_tematica.descricao }}</label>
                                </span>
                            </div>
                        </div>

                    </b-row> 
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header text-center">
                </div>

                <div class="card-body">
                    <b-row>
                        <b-col cols="12" sm="6" lg="12" class="text-center">
                            <b-form-group label="TÍTULO" style="font-size:20px !important; color:black;">
                                    <textarea 
                                        class="form-control" 
                                        v-on:keyup="liveCountDown" 
                                        v-model="post.titulo" 
                                        name="titulo"
                                        :class="['form-control form-control-sm', {'is-invalid': errors.has(`titulo`)}]"
                                        v-validate="{ required: true }"
                                        ></textarea>

                                        <p>Total restante letras restante: <span v-bind:class="{'text-danger': generateErr }">{{totalRemainCount}}</span></p>

                                <span v-show="errors.has(`titulo`)" class="invalid-feedback">
                                    {{ errors.first(`titulo`) }}
                                </span>
                            </b-form-group>
                        </b-col>


                        <b-col cols="12" sm="12" lg="12" class="text-center">
                            <label label-class="font-weight-bold" style="font-size:20px !important; color:black;">PALAVRAS-CHAVE</label><br />
                            <b-row>
                                <b-col cols="12" sm="6" lg="6">
                                    <b-form-group label="1." label-class="font-weight-bold">
                                        <b-form-input
                                            name="palavra_chave_1"
                                            size="sm"
                                            v-model="post.palavra_chave_1"
                                            type="text"
                                            :disabled="loading"
                                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`palavra_chave_1`)}]"
                                            aria-describedby="input-1-live-feedback"
                                            data-vv-as="Palavra Chave 1"
                                        ></b-form-input>
                                        <span v-show="errors.has(`palavra_chave_1`)" class="invalid-feedback">
                                            {{ errors.first(`palavra_chave_1`) }}
                                        </span>
                                    </b-form-group>
                                </b-col>

                                <b-col cols="12" sm="6" lg="6">
                                    <b-form-group label="2." label-class="font-weight-bold">
                                        <b-form-input
                                            name="palavra_chave_2"
                                            size="sm"
                                            v-model="post.palavra_chave_2"
                                            type="text"
                                            :disabled="loading"
                                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`palavra_chave_2`)}]"
                                            aria-describedby="input-2-live-feedback"
                                            data-vv-as="Palavra Chave 2"
                                        ></b-form-input>
                                        <span v-show="errors.has(`palavra_chave_2`)" class="invalid-feedback">
                                            {{ errors.first(`palavra_chave_2`) }}
                                        </span>
                                    </b-form-group>
                                </b-col>

                                <b-col cols="12" sm="6" lg="6">
                                    <b-form-group label="3." label-class="font-weight-bold">
                                        <b-form-input
                                            name="palavra_chave_3"
                                            size="sm"
                                            v-model="post.palavra_chave_3"
                                            type="text"
                                            :disabled="loading"
                                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`palavra_chave_3`)}]"
                                            aria-describedby="input-3-live-feedback"
                                            data-vv-as="Palavra Chave 3"
                                        ></b-form-input>
                                        <span v-show="errors.has(`palavra_chave_3`)" class="invalid-feedback">
                                            {{ errors.first(`palavra_chave_3`) }}
                                        </span>
                                    </b-form-group>
                                </b-col>

                                <b-col cols="12" sm="6" lg="6">
                                    <b-form-group label="4." label-class="font-weight-bold">
                                        <b-form-input
                                            name="palavra_chave_4"
                                            size="sm"
                                            v-model="post.palavra_chave_4"
                                            type="text"
                                            :disabled="loading"
                                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`palavra_chave_4`)}]"
                                            aria-describedby="input-4-live-feedback"
                                            data-vv-as="Palavra Chave 4"
                                        ></b-form-input>
                                        <span v-show="errors.has(`palavra_chave_4`)" class="invalid-feedback">
                                            {{ errors.first(`palavra_chave_4`) }}
                                        </span>
                                    </b-form-group>
                                </b-col>

                                <b-col cols="12" sm="6" lg="6">
                                    <b-form-group label="5." label-class="font-weight-bold">
                                        <b-form-input
                                            name="palavra_chave_5"
                                            size="sm"
                                            v-model="post.palavra_chave_5"
                                            type="text"
                                            :disabled="loading"
                                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`palavra_chave_5`)}]"
                                            aria-describedby="input-5-live-feedback"
                                            data-vv-as="Palavra Chave 5"
                                        ></b-form-input>
                                        <span v-show="errors.has(`palavra_chave_5`)" class="invalid-feedback">
                                            {{ errors.first(`palavra_chave_5`) }}
                                        </span>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                        </b-col>

                    </b-row>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header text-center">
                    <h2>Coautor(es) e Orientador(es)</h2>
                </div>

                <div class="card-body">
                    <b-row>
                        <b-col cols="12" sm="6" lg="6" class="text-center">
                            <b-form-group label="Nome completo (eventuais erros sairão no certificado)" label-class="font-weight-bold">
                                <b-form-input
                                    name="nome_completo"
                                    size="sm"
                                    v-model="post.nome_completo"
                                    type="text"
                                    :disabled="loading"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`nome_completo`)}]"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="Nome completo"
                                ></b-form-input>
                                <span v-show="errors.has(`nome_completo`)" class="invalid-feedback">
                                    {{ errors.first(`nome_completo`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="3" lg="3" class="text-center">
                            <b-form-group label="CPF" label-class="font-weight-bold">
                                <b-form-input
                                    name="cpf"
                                    size="sm"
                                    :disabled="loading"
                                    v-model="post.cpf"
                                    type="text"
                                    v-mask="'###.###.###-##'"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`cpf`)}]"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="CPF"
                                ></b-form-input>
                                <span v-show="errors.has(`cpf`)" class="invalid-feedback">
                                    {{ errors.first(`cpf`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="3" lg="3" class="text-center">
                            <b-form-group label="Categoria" label-class="font-weight-bold">
                                <b-form-select
                                    :disabled="loading"
                                    name="categoria"
                                    v-validate="{ required: true }"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`categoria`)}]"
                                    size="sm"
                                    data-vv-as="Categoria"
                                    class="form-control form-control-sm"
                                    v-model="post.categoria"
                                >
                                    <option :value="null">Selecione a Titulação</option>
                                    <option value="1">Coautor(a)</option>
                                    <option value="2">Orientador(a)</option>
                                </b-form-select>
                                <span class="invalid-feedback">
                                Atenção: os recém-graduados (2021 - 2022) deverão selecionar a titulação "Estudante de graduação"
                                </span>

                                <span v-show="errors.has(`categoria`)" class="invalid-feedback">
                                    {{ errors.first(`categoria`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="12" lg="12" class="text-center">
                            <b-row>
                                <b-col cols="6" sm="6" lg="6">
                                    <b-form-checkbox
                                        id="termo_autoria"
                                        v-model="post.termo_autoria"
                                        name="termo_autoria"
                                        :value="post.termo_autoria"
                                        >
                                        TERMO DE AUTORIA
                                    </b-form-checkbox>

                                    <b-button v-b-modal.modal-termo-autoria>Ver Termo de autoria</b-button>

                                </b-col>

                                <b-col cols="6" sm="6" lg="6">
                                    <b-form-checkbox
                                        id="autorizacao"
                                        v-model="post.autorizacao"
                                        name="autorizacao"
                                        :value="post.autorizacao"
                                        >
                                        AUTORIZAÇÃO
                                    </b-form-checkbox>

                                    <b-button v-b-modal.modal-autorizacao>Ver Autorização</b-button>

                                </b-col>

                            </b-row>
                        </b-col>
                    </b-row>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col d-flex justify-content-end">
                            <b-button :disabled=" loading" size="md" variant="outline-danger" class="align-self-end m-1" @click="back()">
                                Voltar
                            </b-button>

                            <b-button :disabled=" loading" size="md" variant="outline-success" class="align-self-end m-1" @click="save()">
                                Salvar
                            </b-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <b-modal id="modal-termo-autoria">
        Declaro que responsabilizo-me pela originalidade e autoria do trabalho submetido à apreciação para esse congresso, atestando que todos os trechos que tenham sido transcritos de outros documentos (publicados ou não) e que não sejam de minha exclusiva autoria estão citados entre aspas e está identificada a fonte e a página de que foram extraídas (se transcrito literalmente) ou somente indicadas fonte e ano (se utilizada a ideia do autor citado), conforme normas e padrões ABNT vigentes.

        Declaro, ainda, estar ciente que a infração destas normas incorrerá nas responsabilidades civis e criminais da legislação vigente – Lei n. 9610/98 – de Direitos Autorias, que neste caso serão por mim assumidas integralmente.
     </b-modal>
    <b-modal id="modal-autorizacao">
        Autorizo a INTERCOM – Sociedade Brasileira de Estudos Interdisciplinares da Comunicação a publicar no seu site ou nas demais publicações científicas sob sua tutela o texto de minha autoria, da qual dispenso qualquer tipo de remuneração ou contraprestação econômica pela divulgação.

        Declaro, para os devidos fins, sob a responsabilidade civil e criminal da legislação atual vigente, que eu sou o autor do artigo. Declaro, ainda, que o artigo é INÉDITO no Brasil e sua publicação não encontra-se pendente em outro local, considerando-se licenciado com EXCLUSIVIDADE para a INTERCOM, por prazo indeterminado a contar da finalização da submissão do texto.
    </b-modal>

    <notifications group="submit" position="center bottom" width="700px" />
</div>

</template>

<script>
    import debounce from 'debounce'
    import moment from 'moment'
    import MixinsGlobal from  '../../mixins/global-mixins'

      export default {
        props: ['user' , 'regiao'],
        mixins: [ MixinsGlobal],
        data() {
            return {
                loading: false,
                baseUrl: process.env.MIX_BASE_URL,
                divisoes_tematicas: [],
                titulacoes: [],
                loading: false,
                verify: null,
                tipo: null,
                limitmaxCount: 200,
                totalRemainCount: 200,
                generateErr: false,
                post: {
                    id: null,
                    name: null,
                    cpf: null,
                    divisoes_tematicas: [],
                    acessos: [],
                    endereco: {
                        id: null,
                        cep: null,
                        logradouro: null,
                        bairro: null, 
                        municipio: null,
                        estado: null,
                        pais: null,
                    },
                    _method: 'post'
                },
                options: [
                    { text: 'Não', value: 0 },
                    { text: 'Sim', value: 1 },
                ],
                titulacoes: [
                    { text: 'Selecione a Titulação', value: null },
                    { text: 'Estudante de Graduação', value: 1 },
                    { text: 'Bacharel', value: 2 },
                    { text: 'Livre Docente', value: 3 },
                    { text: 'Mestrando', value: 4 },
                    { text: 'Doutorando', value: 5 },
                    { text: 'Mestre', value: 6 },
                    { text: 'Doutor', value: 7 },
                    { text: 'Cursando Especialização', value: 8 },
                    { text: 'Especialista', value: 9 },
                    { text: 'Licenciado', value: 10 }
                ],

            }
        },
        watch: {
            user(){
                if(this.user){
                    this.$forceUpdate()
                    this.post._method = "post"
                    this.post.id = this.user.id ? this.user.id : null
                    this.post.name = this.user.name ? this.user.name : null
                    this.post.instituicao_id = this.user && this.user.associado ? this.user.associado.instituicao_id : null
                    this.post.categoria_inscricao = this.user && this.user.regional_sul && this.user.regional_sul.submissao ? this.user.regional_sul.submissao.categoria_inscricao : null
                    this.post.regiao = this.user && this.user.regional_sul ? this.user.regional_sul.regiao : null
                    this.post.ativo = this.user.ativo ? this.user.ativo : null
                    this.post.divisoes_tematicas = this.find_divisoes_tematicas

                }
            },
        },
        computed: {
            find_divisoes_tematicas() {
                return this.user && this.user.todos_divisoes_tematicas ? this.user.todos_divisoes_tematicas.map(res => res.id)  : []
            }
        },
        methods: {  
            async save() {
                await this.$validator.validateAll().then((valid) => {
                    
                    if(valid) {
                        
                        if(this.post && this.post.taxa_inscricao && this.post.taxa_inscricao.id == 4 && this.user.anuidade_2022 == false){
                            this.loading = false
                            this.message('Sócio da Intercom', 'Precisar ser filiado e estar com a anuidade de 2022 em dia, troque a categoria para prosseguir', 'error');
                        } else{

                            this.message('Aguarde...', 'Estamos salvando suas informações', 'info');

                            setTimeout(() => {
                                var dados = this.post;

                                let urlSave = this.baseUrl+"/regional/sul/save";

                                $.ajax({
                                    method: "POST",
                                    url: urlSave,
                                    headers: {
                                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                                    },
                                    data: $.param(dados),
                                    dataType: "json",
                                    success: (res) => {
                                        if (res.message == "error") {
                                        } else {
                                            this.message(
                                                "Erro",
                                                "Erro ao tentar salvar seus dados, tente novamente dentro de alguns minutos ",
                                                "error"
                                                
                                            );
                                            this.loading = false;
                                        }
                                        this.message(
                                            "Sucesso",
                                            "Seus dados foram alterados com sucesso",
                                            "success",
                                            
                                        );
                                        this.loading = false;
                                    },
                                    error: (error) => {
                                        console.log(error);
                                        if (error.status == 422) {
                                            if (error.response.message == "The given data was invalid.") {
                                                this.loading = false;
                                                return this.message(
                                                    "Campos Obrigatórios",
                                                    "Preencha todos os campos obrigatórios",
                                                    "error"
                                                );
                                            }
                                        }
                                        if (error.status == 500) {
                                            this.loading = false;
                                            this.message(
                                                "Erro",
                                                "Erro ao tentar salvar seus dados, tente novamente dentro de alguns minutos ",
                                                "error",
                                                -1
                                            );
                                        }
                                        if (error.status == 403) {
                                            if (
                                                error.response.message == "This action is unauthorized."
                                            ) {
                                                this.loading = false;
                                                this.message("Erro", "Ação não autorizada.", "error");
                                            }
                                        }
                                        this.loading = false;
                                        this.message(
                                            "Erro",
                                            "Erro ao tentar salvar seus dados, tente novamente dentro de alguns minutos ",
                                            "error"
                                            
                                        );
                                    },
                                });
                            }, 1000);

                        }


                } else {
                        this.loading = false
                        this.message('Campos Obrigatórios', 'Preencha todos os campos obrigatórios', 'error');
                    }
                })
            },
            back(){
                window.history.back();
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
            liveCountDown: function() {
                this.totalRemainCount = this.limitmaxCount - this.post.titulo.length;
                this.generateErr = this.totalRemainCount < 0;
            }
        },
        created() {
            this.getDivisoesTematicas()
        }
    }
</script>
