<template>

<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                        <h1>  Cadastro </h1>
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
                            <b-form-group label="Nome" label-class="font-weight-bold">
                                <b-form-input
                                    name="name"
                                    size="sm"
                                    v-model="post.name"
                                    type="text"
                                    :disabled="loading"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`name`)}]"
                                    v-validate="{ required: true }"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="name"
                                ></b-form-input>
                                <span v-show="errors.has(`name`)" class="invalid-feedback">
                                    {{ errors.first(`name`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col>
                            <b-form-group label="E-mail" label-class="font-weight-bold" cols="12" sm="6" lg="6">
                                <b-form-input
                                    name="email"
                                    size="sm"
                                    v-model="post.email"
                                    type="text"
                                    :disabled="loading"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`email`)}]"
                                    v-validate="{ required: true, email: true, emailCadastro: post.id }"
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
                                    type="password"
                                    v-validate="{ required: passRequired, min:6}"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`password`)}]"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="Senha"
                                ></b-form-input>
                                <span v-show="errors.has(`password`)" class="invalid-feedback">
                                    {{ errors.first(`password`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group
                                label="Estrangeiro"
                                label-class="font-weight-bold"
                                >
                                <b-form-radio-group
                                    :disabled="loading"
                                    v-model="post.estrangeiro"
                                    :options="options"
                                    :button-variant="`outline-primary`" 
                                    size="sm"
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
                                    v-mask="'########'"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`passaporte`)}]"
                                    v-validate="{ required: true, passaporteCheck: post.id }"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="Passaporte"
                                ></b-form-input>
                                <span v-show="errors.has(`passaporte`)" class="invalid-feedback">
                                    {{ errors.first(`passaporte`) }}
                                </span>
                            </b-form-group>
                        </b-col>


                        <b-col cols="12" sm="6" lg="6" v-if="!post.estrangeiro">
                            <b-form-group label="CPF" label-class="font-weight-bold">
                                <b-form-input
                                    name="cpf"
                                    size="sm"
                                    :disabled="loading"
                                    v-model="post.cpf"
                                    type="text"
                                    v-mask="'###.###.###-##'"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`cpf`)}]"
                                    v-validate="{ required: true, cpfCheck: post.id }"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="CPF"
                                ></b-form-input>
                                <span v-show="errors.has(`cpf`)" class="invalid-feedback">
                                    {{ errors.first(`cpf`) }}
                                </span>
                            </b-form-group>
                        </b-col>
                    </b-row>                

                    <b-row v-if="post.associado">
                        <b-col cols="12" sm="6" lg="6" v-if="!post.estrangeiro">
                            <b-form-group label="RG" label-class="font-weight-bold">
                                <b-form-input
                                    name="rg"
                                    size="sm"
                                    :disabled="loading"
                                    v-model="post.rg"
                                    type="text"
                                    v-mask="'##.###.###-#'"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`rg`)}]"
                                    v-validate="{ required: true }"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="RG"
                                ></b-form-input>
                                <span v-show="errors.has(`rg`)" class="invalid-feedback">
                                    {{ errors.first(`rg`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="6" v-if="!post.estrangeiro">
                            <b-form-group label="Orgão expedidor" label-class="font-weight-bold">
                                <b-form-input
                                    name="orgao_expedidor"
                                    size="sm"
                                    :disabled="loading"
                                    v-model="post.orgao_expedidor"
                                    type="text"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`orgao_expedidor`)}]"
                                    v-validate="{ required: true }"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="Orgão expedidor"
                                ></b-form-input>
                                <span v-show="errors.has(`orgao_expedidor`)" class="invalid-feedback">
                                    {{ errors.first(`orgao_expedidor`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group label="Telefone" label-class="font-weight-bold">
                                <b-form-input
                                    name="telefone"
                                    size="sm"
                                    :disabled="loading"
                                    v-model="post.telefone"
                                    type="text"
                                    v-mask="['(##) #####-####', '(##) ####-####']"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`telefone`)}]"
                                    v-validate="{ required: true }"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="CNPJ/CPF"
                                ></b-form-input>
                                <span v-show="errors.has(`telefone`)" class="invalid-feedback">
                                    {{ errors.first(`telefone`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group label="Celular" label-class="font-weight-bold">
                                <b-form-input
                                    name="celular"
                                    size="sm"
                                    :disabled="loading"
                                    v-model="post.celular"
                                    type="text"
                                    v-mask="['(##) ####-####', '(##) #####-####']"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`celular`)}]"
                                    v-validate="{ required: true }"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="Celular"
                                ></b-form-input>
                                <span v-show="errors.has(`celular`)" class="invalid-feedback">
                                    {{ errors.first(`celular`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group label="Gênero" label-class="font-weight-bold">
                                <b-form-select
                                    :disabled="loading"
                                    name="generos"
                                    v-validate="{ required: true }"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`generos`)}]"
                                    size="sm"
                                    data-vv-as="Gênero"
                                    class="form-control form-control-sm"
                                    v-model="post.sexo_id"
                                >
                                <option :value="null">Selecione</option>
                                <option v-for="genero in generos" :value="genero.id" :key="genero.id">
                                    {{ genero.tipo_sexo }}
                                </option>
                                </b-form-select>
                                <span v-show="errors.has(`generos`)" class="invalid-feedback">
                                    {{ errors.first(`generos`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="6">
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

                        <b-col cols="12" sm="6" lg="6">
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

                    </b-row> 

                    <b-row v-if="post.associado">
                        <div class="col-12 d-flex justify-content-between">
                            <label class="font-weight-bold" >Endereço</label>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group ">
                                        <label class="font-weight-bold">CEP</label>
                                        <b-form-input
                                            size="sm"
                                            v-validate="{ min: 9,required: true }"
                                            :name="`cep`" @change="getCep()" v-mask="'#####-###'"
                                            placeholder="Digite aqui"
                                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`cep`)}]"
                                            data-vv-as="CEP"
                                            v-model="post.enderecos.cep"
                                            type="text"
                                            :disabled="loading"
                                        ></b-form-input>
                                        <span v-show="errors.has(`cep`)" class="invalid-feedback d-block">
                                            {{ errors.first(`cep`) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group ">
                                        <label class="font-weight-bold">logradouro</label>
                                        <b-form-input
                                            size="sm"
                                            :name="`logradouro`"
                                            v-validate="{ required: true }"
                                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`logradouro`)}]"
                                            data-vv-as="logradouro"
                                            v-model="post.enderecos.logradouro"
                                            type="text"
                                            :disabled="loading"
                                        ></b-form-input>
                                        <span v-show="errors.has(`logradouro`)" class="invalid-feedback d-block">
                                            {{ errors.first(`logradouro`) }}
                                        </span>
                                    </div>
                                </div>                

                                <div class="form-group col-12 col-md-6 col-lg-6">
                                    <label class="font-weight-bold">Estado</label>
                                    <v-select
                                        class="flex-fill"
                                        :options="estados"
                                        data-vv-as="estado"
                                        :selectOnTab="true"
                                        v-model="post.enderecos.estado"
                                        v-validate="{ required: true }"
                                        :disabled="loading"
                                        :class="[ {'v-select-invalid': errors.has(`estado`)}]"        
                                        label="sigla"
                                        @input="getMunicipios()"
                                        :name="`estado`"
                                        >
                                        <template v-slot:no-options="{ search, searching }">
                                            <template v-if="searching">
                                                Nada encontrado com <em>{{ search }}</em>.
                                            </template>
                                            <em style="opacity: 0.5;" v-else>Começe a digitar algo.</em>
                                        </template>
                                    </v-select>
                                    <span v-show="errors.has(`estado`)" class="v-select-invalid-feedback">
                                        {{ errors.first(`estado`) }}
                                    </span>
                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-6">
                                    <label class="font-weight-bold">Município</label>
                                    <v-select
                                        class="flex-fill"
                                        :name="`municipio`"
                                        :disabled="loading"
                                        :options="municipios"
                                        :selectOnTab="false"
                                        v-validate="{ required: true }"
                                        v-model="post.enderecos.municipio"
                                        label="nome"
                                        data-vv-as="municipio"
                                        :class="{'v-select-invalid': errors.has(`municipio`)}"
                                    ></v-select>
                                    <span v-show="errors.has(`municipio`)" class="v-select-invalid-feedback">
                                        {{ errors.first(`municipio`) }}
                                    </span>
                                </div>

                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group label="País" label-class="font-weight-bold">
                                <b-form-input
                                    name="pais"
                                    size="sm"
                                    v-model="post.pais"
                                    type="text"
                                    :disabled="loading"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`pais`)}]"
                                    v-validate="{ required: true }"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="País"
                                ></b-form-input>
                                <span v-show="errors.has(`pais`)" class="invalid-feedback">
                                    {{ errors.first(`pais`) }}
                                </span>
                            </b-form-group>
                        </b-col>
                            </div>
                        </div>
                    </b-row> 

                </div>
                <div class="card-footer">
                    <div v-if="post.associado">
                        <b-button :disabled=" loading" size="md" variant="outline-success" @click="pagar(post)">
                            Pagar
                        </b-button>
                    </div>

                    <div v-else>
                        <b-button :disabled=" loading" size="md" variant="outline-success" @click="save()">
                            Cadastrar
                        </b-button>
                    </div>

                </div>

            </div>
        </div>
        <pagar-modal :selectedPagar="selectedPagar" v-if="post.associado"></pagar-modal>
    </div>
</div>

</template>

<script>
  import MixinsGlobal from  '../mixins/global-mixins'
  import debounce from 'debounce'

      export default {
        props: ['user'],
        mixins: [ MixinsGlobal],
        components: {
            'pagar-modal': () => import('../cadastro/PagarModal.vue'),
        },
        data() {
            return {
                loading: false,
                selectedPagar: null,
                generos: [],
                estados: [],
                municipios: [],
                generos: [],
                instituicoes: [],
                paises: [],
                titulacoes: [],

                loading: false,
                verify: null,
                post: {
                    id: null,
                    name: null,
                    email: null,
                    password: null,
                    estrangeiro: 0,
                    data_nascimento: null,
                    orgao_expedidor: null,                    
                    cpf: null,
                    rg:null,
                    telefone: null,
                    celular: null,
                    sexo_id: null,
                    todos_tipos_id: 3,
                    ativo: 0,
                    acessos: [],
                    enderecos: {
                        id: null,
                        cep: null,
                        logradouro: null,
                        bairro: null, 
                        municipio: null,
                        estado: null,
                    },
                    _method: 'post'
                },
                options: [
                    { text: 'Não', value: 0 },
                    { text: 'Sim', value: 1 },
                ],
                associado: [
                    { text: 'Usuário', value: 0 },
                    { text: 'Associado', value: 1 },
                ],

            }
        },
        watch: {
            user(){
                debounce(this.getEstados(), 1000)
                console.log(this.user)
                if(this.user){
                    this.post._method = "post"
                    this.post.id = this.user.id
                    this.post.name = this.user.name
                    this.post.email = this.user.email
                    this.post.password = this.user.password
                    this.post.cpf = this.user.cpf
                    this.post.rg = this.user.rg
                    this.post.orgao_expedidor = this.user.orgao_expedidor
                    this.post.estrangeiro = this.user.estrangeiro
                    this.post.passaporte = this.user.passaporte
                    this.post.data_nascimento = this.user.data_nascimento
                    this.post.sexo_id = this.user.sexo_id
                    this.post.celular = this.user.celular
                    this.post.telefones = this.user.telefones
                    this.post.enderecos = this.user.enderecos
                    this.post.instituicao_id = this.user.instituicao_id
                    this.post.titulacao_id = this.user.titulacao_id
                    this.post.associado = this.user.associado
                    this.post.ativo = this.user.ativo
                }
            }

        },
        computed: {
            passRequired() {
                return this.post && this.post.id ? false : true
            },
            
        },
        methods: {  
            async getEstados(){
                await axios.get(`${process.env.MIX_BASE_URL}/get/estados`).then( res => {
                    this.estados = res.data
                })
            },
            async getMunicipios() {
                if(this.post.enderecos && this.post.enderecos.estado) {
                    await axios.get(`${process.env.MIX_BASE_URL}/get/municipios/${this.post.enderecos.estado.id}`).then(res => {
                        this.municipios =  res.data
                    }).then(() => {
                        if(this.selected && this.selected.enderecos) {
                            this.post.enderecos.municipio = this.municipios.find(municipio => municipio.nome == this.selected.enderecos.municipio.nome)
                            this.$validator.reset(`municipio${i}`)
                        }
                    })
                }
            },
            async getCep() {
                if(this.post.enderecos.cep.length > 8) {
                    await fetch(`https://viacep.com.br/ws/${this.post.enderecos.cep}/json`).then(res => res.json())
                        .then(res => {
                            this.post.enderecos = {
                                cep: this.post.enderecos.cep,
                                logradouro: res.logradouro,
                                bairro: res.bairro,
                                estado: this.estados.find(uf => uf.sigla == res.uf),
                                municipio: null,
                                id: this.post.enderecos.id,
                                numero: this.post.enderecos.numero,
                                complemento: null,
                                deleted: false

                            }
                            this.location = res.localidade

                            if(res.erro == true) {
                                this.$notify({
                                    group: "submit",
                                    title: "Erro",
                                    text: 'Endereço não encontrado!, tente novamente.',
                                    type: "error"
                                })
                                this.loading = false
                            }
                        })
                      
                    await this.getMunicipios()
                        this.post.enderecos.municipio = this.municipios.find(municipio => municipio.nome == this.location)
                        this.$forceUpdate()                

                }
            },
            async save() {
                this.loading = true
                await this.$validator.validateAll().then((valid) => {
                    if(valid) {
                        this.message('Aguarde...', 'Estamos salvando suas informações', 'info', -1);

                        setTimeout(() => {
                            axios.post(`${process.env.MIX_BASE_URL}/cadastro/save`, this.post).then( res => {
                                console.log(res)
                                this.clear()

                                this.message('Sucesso', res.status == 201 ? 'Usuário cadastrado.' : 'Usuário atualizado.', 'success');
                                
                                if(res.status == 201) {
                                    window.location.href = `${process.env.MIX_BASE_URL}/login?status=1`
                                }
                               
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
                this.post.email = null
                this.post.name = null
                this.post.password = null
                this.post.enderecos = [{
                    logradouro: null, 
                    cep: null, 
                    numero: null,
                    complemento: null,
                    bairro: null,
                    municipio: null,
                    estado: null,
                    deleted: false
                }]
                
                this.post._method = 'post'
                this.$validator.reset('name')
                this.$validator.reset('email')
            },

            pagar(post) {
                this.selectedPagar = post
                $('#pagar').modal({keyboard: false, show: true})
                this.$bvModal.show('pagar')

            }
        },
        created() {
            axios.get(process.env.MIX_BASE_URL+'/get/tiposexo').then(res => {
               
                this.generos = res.data
            })

            axios.get(`${process.env.MIX_BASE_URL}/get/instituicoes`).then(res => {
                this.instituicoes = res.data;
            })

            axios.get(`${process.env.MIX_BASE_URL}/get/titulacoes`).then(res => {
                this.titulacoes = res.data;
            })
          
            this.getEstados()

        },

    }
</script>
