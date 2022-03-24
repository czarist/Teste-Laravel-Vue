<template>

<div >
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <h2 class="title">Sistema Unificado Intercom</h2>
                </div>

                <ul class="list-group list-group-flush text-center">
                    <li class="list-group-item ">
                        <b-col cols="12" sm="12" lg="12" size="lg">
                            <b-form-group size="lg"
                            >
                                <b-form-radio-group
                                    :disabled="loading"
                                    v-model="post.associado"
                                    :options="associado"
                                    :button-variant="`outline-primary`" 
                                    size="lg"
                                    v-validate="{ required: post.associado == 0 ? true : false }"
                                    name="associado"
                                    buttons
                                ></b-form-radio-group>
                                <span v-show="errors.has(`associado`)" class="invalid-feedback d-block">
                                    {{ errors.first(`associado`) }}
                                </span>
                            </b-form-group>
                        </b-col>
                    </li>
                </ul>

                <div class="card-body">
                    <b-row>
                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group label="Nome Completo" label-class="font-weight-bold">
                                <span class="invalid-feedback mb-1">
                                    *Atenção digite o seu nome completo corretamente, pois será utilizado para pagamentos posteriores dentro da plataforma e em emissão de certificado
                                </span>
                                <b-form-input
                                    name="name"
                                    size="sm"
                                    v-model="post.name"
                                    type="text"
                                    :disabled="loading"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`name`)}]"
                                    v-validate="{ required: true, fullName: post.name }"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="name"
                                ></b-form-input>
                                <span v-show="errors.has(`name`)" class="invalid-feedback">
                                    {{ errors.first(`name`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group label="CPF" label-class="font-weight-bold">
                                <span class="invalid-feedback mb-1">
                                    *Atenção digite o seu CPF corretamente, pois será utilizado em emissão de certificado e não poderá alterar depois de cadastrado 
                                </span>
                                <b-form-input
                                    name="cpf"
                                    size="sm"
                                    :disabled="loading"
                                    v-model="post.cpf"
                                    type="text"
                                    v-mask="'###.###.###-##'"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`cpf`)}]"
                                    v-validate="{ required: true, cpfCheck: post.cpf, verificaCPF: post.cpf }"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="CPF"
                                ></b-form-input>
                                <span v-show="errors.has(`cpf`)" class="invalid-feedback">
                                    {{ errors.first(`cpf`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group label="E-mail" label-class="font-weight-bold">
                                <b-form-input
                                    name="email"
                                    size="sm"
                                    v-model="post.email"
                                    type="email"
                                    :disabled="loading"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`email`)}]"
                                    v-validate="{ required: true,email: true, emailCadastro: post.id }"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="E-mail"
                                ></b-form-input>
                                <span v-show="errors.has(`email`)" class="invalid-feedback">
                                    {{ errors.first(`email`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group label="Senha" label-class="font-weight-bold">
                                <b-form-input
                                    name="password"
                                    size="sm"
                                    v-model="post.password"
                                    :disabled="loading"
                                    :type="showPassaword"
                                    v-validate="{ required: passRequired, min:6}"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`password`)}]"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="Senha"
                                ></b-form-input>
                                <span v-show="errors.has(`password`)" class="invalid-feedback">
                                    {{ errors.first(`password`) }}
                                </span>
                            </b-form-group>
                            <b-form-checkbox v-model="showHidePasswod" name="check-button" switch >
                                <b v-if="showHidePasswod">Ocultar senha</b>
                                <b v-if="!showHidePasswod">Exibir senha</b>
                            </b-form-checkbox>

                        </b-col>

                        <b-col cols="12" sm="6" lg="6" class="mt-3">
                            <b-form-group
                                label="Estrangeiro"
                                label-class="font-weight-bold"
                                >
                                <b-form-radio-group
                                    :disabled="loading"
                                    v-model="post.estrangeiro"
                                    :options="options"
                                    :button-variant="`outline-primary`" 
                                    v-validate="{ required: post.estrangeiro == 0 ? true : false }"
                                    name="estrangeiro"
                                    buttons
                                ></b-form-radio-group>
                                <span v-show="errors.has(`estrangeiro`)" class="invalid-feedback d-block">
                                    {{ errors.first(`estrangeiro`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="6" v-if="post.estrangeiro">
                            <b-form-group label="Passaporte" label-class="font-weight-bold">
                                <b-form-input
                                    name="passaporte"
                                    size="sm"
                                    :disabled="loading"
                                    v-model="post.passaporte"
                                    type="text"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`passaporte`)}]"
                                    v-validate="{ required: true, passaporteCheck: post.passaporte }"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="Passaporte"
                                ></b-form-input>
                                <span v-show="errors.has(`passaporte`)" class="invalid-feedback">
                                    {{ errors.first(`passaporte`) }}
                                </span>
                            </b-form-group>
                        </b-col>
                    </b-row>                
                </div>
                <div class="card-footer">
                    <div>
                        <b-button :disabled=" loading" size="md" variant="outline-success" @click="save()">
                            Cadastrar
                        </b-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <notifications group="submit" position="bottom center" width="500px" />
</div>

</template>

<script>
  import MixinsGlobal from  '../mixins/global-mixins'
  import $ from 'jquery'

      export default {
        props: ['selected', 'id'],
        mixins: [ MixinsGlobal],
        data() {
            return {
                loading: false,
                selectedPagar: null,
                estados: [],
                municipios: [],
                generos: [],
                instituicoes: [],
                paises: [],
                titulacoes: [],

                loading: false,
                verify: null,
                showHidePasswod: false,
                showPassaword: "password",
                post: {
                    id: null,
                    name: null,
                    email: null,
                    password: null,
                    estrangeiro: 0,
                    associado: 0,
                    cpf: null,
                    rg:null,
                    todos_tipos_id: 3,
                    ativo: 1,
                    acessos: [],
                    _method: 'post'
                },
                options: [
                    { text: 'Não', value: 0 },
                    { text: 'Sim', value: 1 },
                ],
                associado: [
                    { text: 'Cadastre-se', value: 0 },
                ],

            }
        },
        watch: {
            showHidePasswod(){
                this.showPassaword = this.showHidePasswod == true ? 'text' : 'password'; 
            }
        },
        computed: {
            passRequired() {
                return this.post && this.post.id ? false : true
            },

            
        },
        methods: {  
            async save() {
                this.loading = true
                await this.$validator.validateAll().then((valid) => {
                    if(valid) {
                        this.message('Aguarde...', 'Estamos salvando suas informações', 'info', -1);

                        setTimeout(() => {
                                var dados = this.post

                                $.ajax({
                                    method: "POST",
                                    url: "cadastro/save",
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: $.param(dados),
                                    dataType: 'json',
                                    success: (retorna) => {
                                        if (retorna.message == 'error') {

                                            window.location.href = `${process.env.MIX_BASE_URL}/login?error=1`

                                        } else {

                                            this.clear()
                                            this.message('Sucesso', 'Usuário cadastrado.', 'success');

                                            window.location.href = `${process.env.MIX_BASE_URL}/login?status=1`

                                        }
                                    },
                                    error: (retorna) => {
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
                                    }
                                });
                        },1000)
                    } else {
                        this.loading = false
                        this.message('Campos Obrigatórios', 'Preencha todos os campos obrigatórios', 'error');
                    }

                })
            },
            clear() {
                this.post.id = null
                this.post.email = null
                this.post.name = null
                this.post.password = null
                
                this.post._method = 'post'
                this.$validator.reset('name')
                this.$validator.reset('email')
            },
        },
        created: function() {
        },
    }
</script>
