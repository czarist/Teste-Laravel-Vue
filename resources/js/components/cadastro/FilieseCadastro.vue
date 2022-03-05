<template>

<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                        <h1>  Cadastre-se </h1>
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
                                    :disabled="true"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`name`)}]"
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
                                    :disabled="true"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`email`)}]"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="E-mail"
                                ></b-form-input>
                                <span v-show="errors.has(`email`)" class="invalid-feedback">
                                    {{ errors.first(`email`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group
                                label="Estrangeiro"
                                label-class="font-weight-bold"
                                >
                                <b-form-radio-group
                                    :disabled="true"
                                    v-model="post.estrangeiro"
                                    :options="options"
                                    :button-variant="`outline-primary`" 
                                    size="sm"
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
                                    :disabled="true"
                                    v-model="post.passaporte"
                                    type="text"
                                    v-mask="'########'"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`passaporte`)}]"
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
                                    :disabled="true"
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

                        <b-col cols="12" sm="6" lg="6" >
                            <b-form-group label="Data Nascimento" label-class="font-weight-bold">
                                <b-form-input
                                    name="data_nascimento"
                                    size="sm"
                                    :disabled="loading"
                                    v-model="post.data_nascimento"
                                    type="text"
                                    v-mask="'##/##/####'"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`data_nascimento`)}]"
                                    v-validate="{ required: true}"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="Data Nascimento"
                                ></b-form-input>
                                <span v-show="errors.has(`data_nascimento`)" class="invalid-feedback">
                                    {{ errors.first(`data_nascimento`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="6" v-if="!post.estrangeiro">
                            <b-form-group label="RG" label-class="font-weight-bold">
                                <b-form-input
                                    name="rg"
                                    size="sm"
                                    :disabled="loading"
                                    v-model="post.rg"
                                    type="text"
                                    v-validate="{ required: true}"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`rg`)}]"
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
                                    v-validate="{ required: true}"
                                    type="text"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`orgao_expedidor`)}]"
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
                                    v-mask="['(##) ####-####']"
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
                                    v-mask="['(##) #####-####']"
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

                     <hr />
                    <b-row v-if="post.associado">
                        <div class="col-12 d-flex justify-content-between">
                            <label class="font-weight-bold">Endereço</label>
                        </div>
                        <div class="col-12">
                            <div class="row">
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                <label class="font-weight-bold">CEP</label>
                                <b-form-input
                                    size="sm"
                                    v-validate="{ min: 9, required: true }"
                                    :name="`cep`"
                                    @change="getCep()"
                                    v-mask="'#####-###'"
                                    placeholder="Digite aqui"
                                    :class="[
                                    'form-control form-control-sm',
                                    { 'is-invalid': errors.has(`cep`) },
                                    ]"
                                    data-vv-as="CEP"
                                    v-model="post.enderecos.cep"
                                    type="text"
                                    :disabled="loading"
                                ></b-form-input>
                                <span
                                    v-show="errors.has(`cep`)"
                                    class="invalid-feedback d-block"
                                >
                                    {{ errors.first(`cep`) }}
                                </span>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                <label class="font-weight-bold">logradouro</label>
                                <b-form-input
                                    size="sm"
                                    :name="`logradouro`"
                                    v-validate="{ required: true }"
                                    :class="[
                                    'form-control form-control-sm',
                                    { 'is-invalid': errors.has(`logradouro`) },
                                    ]"
                                    data-vv-as="logradouro"
                                    v-model="post.enderecos.logradouro"
                                    type="text"
                                    :disabled="loading"
                                ></b-form-input>
                                <span
                                    v-show="errors.has(`logradouro`)"
                                    class="invalid-feedback d-block"
                                >
                                    {{ errors.first(`logradouro`) }}
                                </span>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                <label class="font-weight-bold">Número</label>
                                <b-form-input
                                    size="sm"
                                    :name="`numero`"
                                    v-validate="{ required: true }"
                                    :class="[
                                    'form-control form-control-sm',
                                    { 'is-invalid': errors.has(`numero`) },
                                    ]"
                                    data-vv-as="Número"
                                    v-model="post.enderecos.numero"
                                    type="number"
                                    :disabled="loading"
                                ></b-form-input>
                                <span
                                    v-show="errors.has(`numero`)"
                                    class="invalid-feedback d-block"
                                >
                                    {{ errors.first(`numero`) }}
                                </span>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                <label class="font-weight-bold">Complemento</label>
                                <b-form-input
                                    size="sm"
                                    :name="`complemento`"
                                    v-validate="{ required: true }"
                                    :class="[
                                    'form-control form-control-sm',
                                    { 'is-invalid': errors.has(`complemento`) },
                                    ]"
                                    data-vv-as="Complemento"
                                    v-model="post.enderecos.complemento"
                                    type="text"
                                    :disabled="loading"
                                ></b-form-input>
                                <span
                                    v-show="errors.has(`complemento`)"
                                    class="invalid-feedback d-block"
                                >
                                    {{ errors.first(`complemento`) }}
                                </span>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                <label class="font-weight-bold">Bairro</label>
                                <b-form-input
                                    size="sm"
                                    :name="`bairro`"
                                    v-validate="{ required: true }"
                                    :class="[
                                    'form-control form-control-sm',
                                    { 'is-invalid': errors.has(`bairro`) },
                                    ]"
                                    data-vv-as="Bairro"
                                    v-model="post.enderecos.bairro"
                                    type="text"
                                    :disabled="loading"
                                ></b-form-input>
                                <span
                                    v-show="errors.has(`bairro`)"
                                    class="invalid-feedback d-block"
                                >
                                    {{ errors.first(`bairro`) }}
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
                                :class="[{ 'v-select-invalid': errors.has(`estado`) }]"
                                label="sigla"
                                @input="getMunicipios()"
                                :name="`estado`"
                                >
                                <template v-slot:no-options="{ search, searching }">
                                    <template v-if="searching">
                                    Nada encontrado com <em>{{ search }}</em
                                    >.
                                    </template>
                                    <em style="opacity: 0.5" v-else
                                    >Começe a digitar algo.</em
                                    >
                                </template>
                                </v-select>
                                <span
                                v-show="errors.has(`estado`)"
                                class="v-select-invalid-feedback"
                                >
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
                                :class="{ 'v-select-invalid': errors.has(`municipio`) }"
                                ></v-select>
                                <span
                                v-show="errors.has(`municipio`)"
                                class="v-select-invalid-feedback"
                                >
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
                                    :class="[
                                    'form-control form-control-sm',
                                    { 'is-invalid': errors.has(`pais`) },
                                    ]"
                                    v-validate="{ required: true }"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="País"
                                ></b-form-input>
                                <span
                                    v-show="errors.has(`pais`)"
                                    class="invalid-feedback"
                                >
                                    {{ errors.first(`pais`) }}
                                </span>
                                </b-form-group>
                            </b-col>
                            </div>
                        </div>
                    </b-row> 
                </div>
                <div class="card-footer row">
                    <div class="col d-flex justify-content-end">
                    <b-button :disabled=" loading" size="md" variant="outline-danger" class="align-self-end m-1" @click="back()">
                        Voltar
                    </b-button>

                    <b-button :disabled=" loading" size="md" variant="outline-success" class="align-self-end m-1" @click="save()">
                            Salvar
                        </b-button>

                        <b-button :disabled=" loading" size="md" variant="outline-success" class="m-1" @click="pagar(post)">
                            Método de Pagamento
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
            'pagar-modal': () => import('./PagarModal'),
        },
        data() {
            return {
                loading: false,
                selectedPagar: null,
                script_pagseguro: null,
                sessions_pagseguro: null,
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
                    associado: 1,
                    associacao: null,
                    data_nascimento: null,
                    orgao_expedidor: null,    
                    instituicao_id: null,    
                    titulacao_id: null,            
                    cpf: null,
                    rg:null,
                    telefone: null,
                    celular: null,
                    sexo_id: null,
                    ativo: 1,
                    acessos: [],
                    enderecos: {
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
                associado: [
                    { text: 'Filie-se', value: 1 },
                ],
            }
        },
        watch: {
            user(){
                if(this.user){
                    this.$forceUpdate()
                    this.post.metodo = "credito"
                    this.post._method = "post"
                    this.post.id = this.user.id ? this.user.id : null
                    this.post.name = this.user.name ? this.user.name : null
                    this.post.email = this.user.email ? this.user.email : null 
                    this.post.password = this.user.password ? this.user.password : null
                    this.post.cpf = this.user.cpf ? this.user.cpf : null
                    this.post.rg = this.user.rg ? this.user.rg : null
                    this.post.orgao_expedidor = this.user.orgao_expedidor ? this.user.orgao_expedidor : null
                    this.post.estrangeiro = this.user.estrangeiro ? 1 : 0
                    this.post.passaporte = this.user.passaporte ? this.user.passaporte : null
                    this.post.data_nascimento = this.user ? moment(this.user.data_nascimento).format("DD-MM-YYYY") : null,
                    this.post.sexo_id = this.user.sexo_id ? this.user.sexo_id : null
                    this.post.celular = this.user.celular ? this.user.celular : null
                    this.post.telefone = this.user.telefone ? this.user.telefone : null
                    this.post.instituicao_id = this.user && this.user.associado ? this.user.associado.instituicao_id : null
                    this.post.titulacao_id = this.user && this.user.associado ? this.user.associado.titulacao_id : null
                    this.post.ativo = this.user.ativo ? this.user.ativo : null,
                    this.post.associacao = this.user.associado ? this.user.associado.associacao : null,
                    this.post.enderecos = {
                        id: this.user && this.user.enderecos && this.user.enderecos[0]                        ? this.user.enderecos[0].id
                            : null,
                        cep:
                            this.user && this.user.enderecos && this.user.enderecos[0]
                            ? this.user.enderecos[0].cep
                            : null,
                        logradouro:
                            this.user && this.user.enderecos && this.user.enderecos[0]
                            ? this.user.enderecos[0].logradouro
                            : null,
                        numero:
                            this.user && this.user.enderecos && this.user.enderecos[0]
                            ? this.user.enderecos[0].numero
                            : null,
                        complemento:
                            this.user && this.user.enderecos && this.user.enderecos[0]
                            ? this.user.enderecos[0].complemento
                            : null,
                        bairro:
                            this.user && this.user.enderecos && this.user.enderecos[0]
                            ? this.user.enderecos[0].bairro
                            : null,
                        municipio:
                            this.user && this.user.enderecos && this.user.enderecos[0]
                            ? this.user.enderecos[0].municipio
                            : null,
                        estado:
                            this.user && this.user.enderecos && this.user.enderecos[0]
                            ? this.user.enderecos[0].municipio.estado
                            : null,
                    },
                    this.post.pais = this.user && this.user.enderecos && this.user.enderecos[0] ? this.user.enderecos[0].pais_id : null
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
                await $.ajax({
                    method: "GET",
                    url: "get/estados",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.estados = res
                    },
                    error: (res) => {
                        console.log(res)
                        
                    }
                }); 
            },
            async getMunicipios() {
                if(this.post.enderecos && this.post.enderecos.estado) {

                    await $.ajax({
                        method: "GET",
                        url: `get/municipios/${this.post.enderecos.estado.id}`,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        dataType: 'json',
                        success: (res) => {
                            this.municipios = res
                            if(this.selected && this.selected.enderecos) {
                                this.post.enderecos.municipio = this.municipios.find(municipio => municipio.nome == this.selected.enderecos.municipio.nome)
                                this.$validator.reset(`municipio}`)
                            }
                        },
                        error: (res) => {
                            console.log(res)
                        }
                    }); 
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
            async pagar(post) {
                this.loading = true
                await this.$validator.validateAll().then((valid) => {
                    if(valid) {

                        this.message('Aguarde...', 'Estamos salvando suas informações', 'info');
                        this.save()

                        this.selectedPagar = post
                        $('#pagar').modal({keyboard: false, show: true})
                        this.$bvModal.show('pagar')
                        this.loading = false

                } else {
                        this.loading = false
                        this.message('Campos Obrigatórios', 'Preencha todos os campos obrigatórios', 'error');
                    }
                })
            },
            async pagamento(){

                await $.ajax({
                    method: "GET",
                    url: "pagseguro/pagamento",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        PagSeguroDirectPayment.setSessionId(res.id);
                        this.sessions_pagseguro = res;
                    },
                    error: (res) => {
                        console.log(res)
                    }
                });
            },
            getGeneros(){
                $.ajax({
                    method: "GET",
                    url: "get/tiposexo",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.generos = res
                    },
                    error: (res) => {
                        console.log(res)
                        
                    }
                }); 
            },
            getTitulacoes(){
                $.ajax({
                    method: "GET",
                    url: "get/titulacoes",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.titulacoes = res
                    },
                    error: (res) => {
                        console.log(res)
                        
                    }
                }); 
            },
            getInstituicoes(){
                $.ajax({
                    method: "GET",
                    url: "get/instituicoes",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.instituicoes = res
                    },
                    error: (res) => {
                        console.log(res)
                        
                    }
                }); 
            },
            async save() {
                setTimeout(() => {
                    var dados = this.post;

                    $.ajax({
                        method: "POST",
                        url: "perfil/save",
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
                                    "error"
                                    
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
            },
            back(){
                window.history.back();
            }


        },
        created() {
            this.getGeneros(),
            this.getTitulacoes(),
            this.getInstituicoes(),
            this.getEstados(),
            setTimeout(() => {
                this.pagamento()

            },3000)

        },
    }
</script>
