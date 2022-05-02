<template>

<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <h1>INDICAÇÃO DA IES </h1>
                </div>

                <div class="card-body">
                    <b-row>
                        <div class="form-group col-12 col-md-6 col-sm-6 col-lg-6">
                            <label class="font-weight-bold">UF</label>
                            <v-select
                                class="flex-fill"
                                :options="estados"
                                :reduce="estados => estados.sigla"
                                data-vv-as="estado"
                                :selectOnTab="true"
                                v-model="post.estado_id"
                                :disabled="loading"
                                :class="[{ 'v-select-invalid': errors.has(`estado_id`) }]"
                                label="sigla"
                                :name="`estado_id`"
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
                            <span v-show="errors.has(`estado_id`)" class="invalid-feedback">
                                {{ errors.first(`estado_id`) }}
                            </span>
                        </div>

                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group label="Instituição:" label-class="font-weight-bold">
                                <b-form-select
                                    :disabled="loading"
                                    name="instituicao"
                                    v-validate="{ required: true }"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`instituicao`)}]"
                                    size="sm"
                                    data-vv-as="Instituição:"
                                    class="form-control form-control-sm"
                                    v-model="post.instituicao_id"
                                >
                                <option :value="null">Selecione</option>
                                <option v-for="instituicao in instituicoes" :value="instituicao.id" :key="instituicao.id">
                                    {{ instituicao.instituicao }} - {{ instituicao.sigla_instituicao }}
                                </option>
                                </b-form-select>
                                <span v-show="errors.has(`instituicao`)" class="invalid-feedback">
                                    {{ errors.first(`instituicao`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group label="Categoria:" label-class="font-weight-bold">
                                <b-form-select
                                    :disabled="loading"
                                    name="categoria"
                                    v-validate="{ required: true }"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`categoria`)}]"
                                    size="sm"
                                    data-vv-as="Categoria:"
                                    class="form-control form-control-sm"
                                    v-model="post.categoria"
                                    @input="getModalidade()"
                                >
                                    <option value="null">Selecione</option>
                                    <option value="Cinema e Audiovisual">Cinema e Audiovisual</option>
                                    <option value="Jornalismo">Jornalismo</option>
                                    <option value="Produção Transdisciplinar">Produção Transdisciplinar</option>
                                    <option value="Publicidade e Propaganda">Publicidade e Propaganda</option>
                                    <option value="Rádio, TV e Internet">Rádio, TV e Internet</option>
                                    <option value="Relações Públicas">Relações Públicas</option>

                                </b-form-select>
                                <span v-show="errors.has(`categoria`)" class="invalid-feedback">
                                    {{ errors.first(`categoria`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <div class="form-group col-12 col-md-6 col-sm-6 col-lg-6">
                            <label class="font-weight-bold">Modalidade</label>
                            <v-select
                            class="flex-fill"
                            :name="`modalidade`"
                            :disabled="loading"
                            :options="modalidades"
                            :reduce="modalidades => modalidades.descricao"
                            :selectOnTab="false"
                            v-validate="{ required: true }"
                            v-model="post.modalidade"
                            label="descricao"
                            data-vv-as="modalidade"
                            :class="{ 'v-select-invalid': errors.has(`modalidade`) }"
                            ></v-select>
                            <span
                            v-show="errors.has(`modalidade`)" class="invalid-feedback">
                                {{ errors.first(`modalidade`) }}
                            </span>
                        </div>

                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group label="Responsável pelas Indicações:" label-class="font-weight-bold">
                                <b-form-select
                                    :disabled="loading"
                                    name="respo_indicacao"
                                    v-validate="{ required: true }"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`respo_indicacao`)}]"
                                    size="sm"
                                    data-vv-as="Responsável pelas Indicações:"
                                    class="form-control form-control-sm"
                                    v-model="post.respo_indicacao"
                                >
                                    <option value="null">Selecione</option>
                                    <option value="Coordenador de Curso">Coordenador de Curso</option>
                                    <option value="Chefe de Departamento">Chefe de Departamento</option>
                                    <option value="Diretor Faculdade">Diretor Faculdade</option>
                                    <option value="Outro">Outro</option>

                                </b-form-select>
                                <span v-show="errors.has(`respo_indicacao`)" class="invalid-feedback">
                                    {{ errors.first(`respo_indicacao`) }}
                                </span>
                            </b-form-group>
                        </b-col>
                      
                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group label="Nome do Responsável" label-class="font-weight-bold">
                                <b-form-input
                                    name="nome_respo"
                                    size="sm"
                                    v-model="post.nome_respo"
                                    type="text"
                                    :disabled="loading"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`nome_respo`)}]"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="Nome do Responsável"
                                    v-validate="{ required: true, fullName: post.nome_respo }"
                                ></b-form-input>
                                <span v-show="errors.has(`nome_respo`)" class="invalid-feedback">
                                    {{ errors.first(`nome_respo`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group label="CPF do Responsável" label-class="font-weight-bold">
                                <b-form-input
                                    name="cpf_respo"
                                    size="sm"
                                    :disabled="loading"
                                    v-model="post.cpf_respo"
                                    type="text"
                                    v-mask="'###.###.###-##'"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`cpf_respo`)}]"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="CPF do Responsável"
                                    v-validate="{ required: true, verificaCPF: post.cpf_respo }"
                                ></b-form-input>
                                <span v-show="errors.has(`cpf_respo`)" class="invalid-feedback">
                                    {{ errors.first(`cpf_respo`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group label="E-mail do Responsável" label-class="font-weight-bold" cols="12" sm="6" lg="6">
                                <b-form-input
                                    name="email_respo"
                                    size="sm"
                                    v-model="post.email_respo"
                                    type="text"
                                    :disabled="loading"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`email_respo`)}]"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="E-mail do Responsável"
                                    v-validate="{ required: true }"
                                ></b-form-input>
                                <span v-show="errors.has(`email_respo`)" class="invalid-feedback">
                                    {{ errors.first(`email_respo`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group label="E-mail do Curso" label-class="font-weight-bold" cols="12" sm="6" lg="6">
                                <b-form-input
                                    name="email_curso"
                                    size="sm"
                                    v-model="post.email_curso"
                                    type="text"
                                    :disabled="loading"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`email_curso`)}]"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="E-mail do Curso"
                                    v-validate="{ required: true }"
                                ></b-form-input>
                                <span v-show="errors.has(`email_curso`)" class="invalid-feedback">
                                    {{ errors.first(`email_curso`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group label="Telefone do Curso" label-class="font-weight-bold">
                                <b-form-input
                                    name="celular"
                                    size="sm"
                                    :disabled="loading"
                                    v-model="post.celular"
                                    type="text"
                                    v-mask="['(##) #####-####']"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`celular`)}]"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="Telefone do Curso"
                                ></b-form-input>
                                <span v-show="errors.has(`celular`)" class="invalid-feedback">
                                    {{ errors.first(`celular`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group label="Nome do autor líder" label-class="font-weight-bold">
                                <b-form-input
                                    name="nome_autor"
                                    size="sm"
                                    v-model="post.nome_autor"
                                    type="text"
                                    :disabled="loading"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`nome_autor`)}]"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="Nome do autor líder"
                                    v-validate="{ required: true, fullName: post.nome_autor }"
                                ></b-form-input>
                                <span v-show="errors.has(`nome_autor`)" class="invalid-feedback">
                                    {{ errors.first(`nome_autor`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group label="CPF do autor líder" label-class="font-weight-bold">
                                <b-form-input
                                    name="cpf_autor"
                                    size="sm"
                                    :disabled="loading"
                                    v-model="post.cpf_autor"
                                    type="text"
                                    v-mask="'###.###.###-##'"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`cpf_autor`)}]"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="CPF do autor líder"
                                    v-validate="{ required: true, cpfCheckIndicacao: post.cpf, verificaCPF: post.cpf_autor }"
                                ></b-form-input>
                                <span v-show="errors.has(`cpf_autor`)" class="invalid-feedback">
                                    {{ errors.first(`cpf_autor`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group label="Trabalho produzido em:" label-class="font-weight-bold">
                                <b-form-select
                                    :disabled="loading"
                                    name="trabalho_produzido"
                                    v-validate="{ required: true }"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`trabalho_produzido`)}]"
                                    size="sm"
                                    data-vv-as="Trabalho produzido"
                                    class="form-control form-control-sm"
                                    v-model="post.trabalho_produzido"
                                >
                                    <option value="null">Selecione</option>
                                    <option value="Agência Escola / Agência Jr">Agência Escola / Agência Jr</option>
                                    <option value="Disciplina">Disciplina</option>
                                    <option value="Extensão Curricular">Extensão Curricular</option>
                                    <option value="Projeto de extensão">Projeto de extensão</option>
                                    <option value="TCC">TCC</option>

                                </b-form-select>
                                <span v-show="errors.has(`trabalho_produzido`)" class="invalid-feedback">
                                    {{ errors.first(`trabalho_produzido`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group label="Orientador(es) do trabalho:" label-class="font-weight-bold">
                                <b-form-input
                                    name="orientador"
                                    size="sm"
                                    v-model="post.orientador"
                                    type="text"
                                    :disabled="loading"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`orientador`)}]"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="Orientador(es) do trabalho"
                                ></b-form-input>
                                <span v-show="errors.has(`orientador`)" class="invalid-feedback">
                                    {{ errors.first(`orientador`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group label="Título do Trabalho:" label-class="font-weight-bold">
                                <b-form-textarea
                                    placeholder="Escreva aqui o título do trabalho..."
                                    v-validate="{ required: true }"
                                    :disabled="loading"
                                    data-vv-as="título do trabalho"
                                    name="titulo_trabalho"
                                    v-model="post.titulo_trabalho"
                                ></b-form-textarea>
                                <span v-show="errors.has(`titulo_trabalho`)" class="invalid-feedback">
                                    {{ errors.first(`titulo_trabalho`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group 
                                label="Atenção: somente o responsável acima poderá indicar trabalhos para a categoria escolhida." v-slot="{ ariaDescribedby }" class="text-danger">
                            <b-form-radio 
                                v-model="post.ciencia" 
                                :aria-describedby="ariaDescribedby" 
                                name="ciencia" 
                                value="1"
                                v-validate="{ required: true }"
                                data-vv-as="Ciência"
                            >Ciente das informações indicadas</b-form-radio>
                            </b-form-group>
                                <span v-show="errors.has(`ciencia`)" class="invalid-feedback">
                                    {{ errors.first(`ciencia`) }}
                                </span>
                        </b-col>

                    </b-row> 
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header text-center">
                    <h2>Endereço do Curso</h2>
                </div>

                <div class="card-body">
                    <b-row >
                        <div class="col-12">
                            <div class="row">
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                <label class="font-weight-bold">CEP</label>
                                <b-form-input
                                    size="sm"
                                    v-validate="{ min: 9}"
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
                                :disabled="loading"
                                :class="[{ 'v-select-invalid': errors.has(`estado`) }]"
                                label="sigla"
                                @input="getMunicipios()"
                                :name="`estado`"
                                v-validate="{ required: true }"
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
                                class="invalid-feedback"
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
                                v-model="post.enderecos.municipio"
                                label="nome"
                                data-vv-as="municipio"
                                v-validate="{ required: true }"
                                :class="{ 'v-select-invalid': errors.has(`municipio`) }"
                                ></v-select>
                                <span
                                v-show="errors.has(`municipio`)"
                                class="invalid-feedback"
                                >
                                {{ errors.first(`municipio`) }}
                                </span>
                            </div>

                            <b-col cols="12" sm="6" lg="6">
                                <b-form-group label="País" label-class="font-weight-bold">
                                <b-form-input
                                    name="pais"
                                    size="sm"
                                    v-model="post.enderecos.pais"
                                    type="text"
                                    :disabled="loading"
                                    :class="[ 'form-control form-control-sm',{ 'is-invalid': errors.has(`pais`) }]"
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

                <div class="card-footer row">
                    <div class="col d-flex justify-content-end">
                    <b-button :disabled=" loading" size="md" variant="outline-danger" class="align-self-end m-1" @click="back()">
                        Voltar
                    </b-button>

                    <b-button :disabled=" loading" size="md" variant="outline-success" class="align-self-end m-1" @click="save()">
                        CADASTRAR
                    </b-button>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <notifications group="submit" position="bottom center" width="600px" />
    <visualizar-modal :selected="selected"></visualizar-modal>

</div>

</template>

<script>
    import MixinsGlobal from  '../mixins/global-mixins'

      export default {
        mixins: [ MixinsGlobal],
        components: {
            'visualizar-modal': () => import('./VisualizarModal'),
        },

        data() {
            return {
                loading: false,
                estados: [],
                municipios: [],
                instituicoes: [],
                paises: [],
                modalidades: [],
                selected: null,
                loading: false,
                radio_internet: null,
                cinema_audiovisual: null,
                jornalismo: null,
                publicidade_propaganda: null,
                relacoes_publicas: null,
                producao_editorial: null,
                post: {
                    id: null,
                    nome_respo: null,
                    cpf_respo: null,
                    respo_indicacao: null,
                    email_respo: null,
                    email_curso: null,
                    celular: null,
                    nome_autor: null,
                    cpf_autor: null,
                    trabalho_produzido: null,
                    orientador: null,
                    titulo_trabalho: null,
                    categoria: null,
                    estado_id: null,
                    instituicao_id: null,
                    modalidade: null,
                    ciencia: null,
                    enderecos: {
                        id: null,
                        cep: null,
                        logradouro: null,
                        numero: null,
                        complemento: null,
                        bairro: null, 
                        municipio: null,
                        estado: null,
                        pais: null,
                    },
                    _method: 'post'
                },
            }
        },
        watch: {
        },
        computed: {
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
                this.loading = true
                
                await this.$validator.validateAll().then((valid) => {
                    if(valid) {
                        this.message('Aguarde...', 'Estamos salvando suas informações', 'info');

                        setTimeout(() => {
                            var dados = this.post;

                            $.ajax({
                                method: "POST",
                                url: "indicacao/save",
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
                                    this.message( "Sucesso", "Seus dados foram alterados com sucesso","success");

                                    this.selected = this.post
                                    $('#visualizar').modal({keyboard: false, show: true})
                                    this.$bvModal.show('visualizar')


                                },
                                error: (error) => {
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
                    } else {
                        this.loading = false;

                        this.message('Campos Obrigatórios', 'Preencha todos os campos obrigatórios', 'error');

                    }           
                })
            },
            back(){
                window.history.back();
            },
            getCinemaAudiovisual(){
                $.ajax({
                    method: "GET",
                    url: "get/cinema-audiovisual",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.cinema_audiovisual = res
                    },
                    error: (res) => {
                        console.log(res)
                        
                    }
                }); 
            },
            getJornalismo(){
                $.ajax({
                    method: "GET",
                    url: "get/jornalismo",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.jornalismo = res
                    },
                    error: (res) => {
                        console.log(res)
                        
                    }
                }); 
            },
            getPublicidadePropaganda(){
                $.ajax({
                    method: "GET",
                    url: "get/publicidade-propaganda",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.publicidade_propaganda = res
                    },
                    error: (res) => {
                        console.log(res)
                        
                    }
                }); 
            },
            getRelacoesPublicas(){
                $.ajax({
                    method: "GET",
                    url: "get/relacoes-publicas",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.relacoes_publicas = res
                    },
                    error: (res) => {
                        console.log(res)
                        
                    }
                }); 
            },
            getProdEdit(){
                $.ajax({
                    method: "GET",
                    url: "get/producao-editorial",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.producao_editorial = res
                    },
                    error: (res) => {
                        console.log(res)
                        
                    }
                }); 
            },
            getRadioInternet(){
                $.ajax({
                    method: "GET",
                    url: "get/radio-internet",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.radio_internet = res
                    },
                    error: (res) => {
                        console.log(res)
                        
                    }
                }); 
            },
            getModalidade() {
                if(this.post && this.post.categoria) {
                    switch (this.post.categoria)
                    {
                    case "Cinema e Audiovisual":
                        this.modalidades = this.cinema_audiovisual;
                        break;
                    case "Jornalismo":
                        this.modalidades = this.jornalismo;
                        break;
                    case "Produção Transdisciplinar":
                        this.modalidades = this.producao_editorial;
                        break;
                    case "Publicidade e Propaganda":
                        this.modalidades = this.publicidade_propaganda;
                        break;
                    case "Rádio, TV e Internet":
                        this.modalidades = this.radio_internet;
                        break;
                    case "Relações Públicas":
                        this.modalidades = this.relacoes_publicas;
                        break;
                    default: 
                        this.modalidades = null;
                    }
                }
            }
        },
        created() {
            this.getInstituicoes(),
            this.getEstados(),
            this.getCinemaAudiovisual(),
            this.getJornalismo(),
            this.getPublicidadePropaganda(),
            this.getRelacoesPublicas(),
            this.getProdEdit(),
            this.getRadioInternet()

        },
    }
</script>

<style scoped>
    ::v-deep .hr {
        border-top: 5px solid #121212 !important;
    }
    ::v-deep .vue-notification {
        font-size: 15px !important;
    }

</style>
