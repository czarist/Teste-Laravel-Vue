<template>

<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <h1>FICHA DE AVALIADOR {{ this.form_jr ? "DTs e IJs" : "EXPOCOM"}}</h1>
                </div>

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
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="Celular"
                                ></b-form-input>
                                <span v-show="errors.has(`celular`)" class="invalid-feedback">
                                    {{ errors.first(`celular`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group label="Nome da Instituição:" label-class="font-weight-bold">
                                <b-form-select
                                    :disabled="loading"
                                    name="instituicao"
                                    v-validate="{ required: true }"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`instituicao`)}]"
                                    size="sm"
                                    data-vv-as="Nome da Instituição:"
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
                            <b-form-group label="Titulação Acadêmica:" label-class="font-weight-bold">
                                <b-form-select
                                    :disabled="loading"
                                    name="titulacao"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`titulacao`)}]"
                                    size="sm"
                                    data-vv-as="Titulação Acadêmica:"
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
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header text-center">
                    <h2>Endereço</h2>
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
                                    :class="[ 'form-control form-control-sm',{ 'is-invalid': errors.has(`pais`) }]"
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
            </div>

            <div class="card mt-3">
                <div class="card-header text-center">
                    <h2>{{ form_jr == 1 ? 'ÁREAS' : 'CATEGORIAS E MODALIDADES'}}</h2>
                </div>

                <div class="card-body">
                    <b-row>
                        <div class="col-12  text-center" v-if="this.form_jr">
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

                        <div class="col-12 mt-5 mb-2 text-center" v-if="this.form_jr">
                            <label for="ativo text-center" label-class="font-weight-bold" style="font-size:20px !important; color:black;" >CLIQUE NOS BOTÕES E ESCOLHA INTERCOM JÚNIOR:</label><br />
                            <div class="switch-field-one" >
                                <span v-for="(divisoes_tematicas_jr, indexJunior) in divisoes_tematicas_jr" :key="indexJunior">
                                    <input
                                        :disabled="loading"
                                        :id="`dvj_${indexJunior}`"
                                        name="divisoes_tematicas_jr"
                                        :class="[ 'form-control radio-inline radio_lista radio',{ 'is-invalid': errors.has(`divisoes_tematicas_jr`) }]"                                        
                                        aria-describedby="input-1-live-feedback"
                                        data-vv-as="DIVISÃO TEMÁTICA JR"
                                        type="checkbox"
                                        :value="divisoes_tematicas_jr.id"
                                        v-model="post.divisoes_tematicas_jr"
                                    ><label :key="`label_${indexJunior}`" :for="`dvj_${indexJunior}`" class="mr-2">{{ divisoes_tematicas_jr.dt }} - {{ divisoes_tematicas_jr.descricao }}</label>
                                </span>
                            </div>
                        </div>

                        <div class="col-12 mt-5 mb-2 text-center" v-if="!this.form_jr">
                            <label for="ativo" label-class="font-weight-bold" style="font-size:20px !important; color:black;">CLIQUE NOS BOTÕES PARA ESCOLHER CATEGORIAS DE CINEMA E AUDIOVISUAL:</label><br />
                            <div class="switch-field-one" >
                                <span v-for="(cinema_audiovisual, indexCA) in cinema_audiovisual" :key="indexCA">
                                    <input
                                        :disabled="loading"
                                        :id="`ca_${indexCA}`"
                                        name="cinema_audiovisual"
                                        :class="[ 'form-control radio-inline radio_lista radio',{ 'is-invalid': errors.has(`cinema_audiovisual`) }]"                                        
                                        aria-describedby="input-1-live-feedback"
                                        data-vv-as="CINEMA E AUDIOVISUAL"
                                        type="checkbox"
                                        :value="cinema_audiovisual.id"
                                        v-model="post.cinema_audiovisual"
                                    ><label :key="`label_${indexCA}`" :for="`ca_${indexCA}`" class="mr-2">{{ cinema_audiovisual.descricao }}</label>
                                </span>
                            </div>
                        </div>

                        <div class="col-12 mt-5 mb-2 text-center" v-if="!this.form_jr">
                            <label for="ativo" label-class="font-weight-bold" style="font-size:20px !important; color:black;">CLIQUE NOS BOTÕES PARA ESCOLHER CATEGORIAS DE JORNALISMO:</label><br />
                            <div class="switch-field-one" >
                                <span v-for="(jornalismo, indexJornalismo) in jornalismo" :key="indexJornalismo">
                                    <input
                                        :disabled="loading"
                                        :id="`jorn_${indexJornalismo}`"
                                        name="jornalismo"
                                        :class="[ 'form-control radio-inline radio_lista radio',{ 'is-invalid': errors.has(`jornalismo`) }]"                                        
                                        aria-describedby="input-1-live-feedback"
                                        data-vv-as="JORNALISMO"
                                        type="checkbox"
                                        :value="jornalismo.id"
                                        v-model="post.jornalismo"
                                    ><label :key="`label_${indexJornalismo}`" :for="`jorn_${indexJornalismo}`" class="mr-2">{{ jornalismo.descricao }}</label>
                                </span>
                            </div>
                        </div>

                        <div class="col-12 mt-5 mb-2 text-center" v-if="!this.form_jr">
                            <label for="ativo" label-class="font-weight-bold" style="font-size:20px !important; color:black;">CLIQUE NOS BOTÕES PARA ESCOLHER CATEGORIAS DE PUBLICIDADE E PROPAGANDA:</label><br />
                            <div class="switch-field-one" >
                                <span v-for="(publicidade_propaganda, indexPublicidadePropaganda) in publicidade_propaganda" :key="indexPublicidadePropaganda">
                                    <input
                                        :disabled="loading"
                                        :id="`pupro_${indexPublicidadePropaganda}`"
                                        name="publicidade_propaganda"
                                        :class="[ 'form-control radio-inline radio_lista radio',{ 'is-invalid': errors.has(`publicidade_propaganda`) }]"                                        
                                        aria-describedby="input-1-live-feedback"
                                        data-vv-as="PUBLICIDADE E PROPAGANDA"
                                        type="checkbox"
                                        :value="publicidade_propaganda.id"
                                        v-model="post.publicidade_propaganda"
                                    ><label :key="`label_${indexPublicidadePropaganda}`" :for="`pupro_${indexPublicidadePropaganda}`" class="mr-2">{{ publicidade_propaganda.descricao }}</label>
                                </span>
                            </div>
                        </div>

                        <div class="col-12 mt-5 mb-2 text-center" v-if="!this.form_jr">
                            <label for="ativo" label-class="font-weight-bold" style="font-size:20px !important; color:black;">CLIQUE NOS BOTÕES PARA ESCOLHER CATEGORIAS DE RELAÇÕES PÚBLICAS:</label><br />
                            <div class="switch-field-one" >
                                <span v-for="(relacoes_publicas, indexRelacoesPublicas) in relacoes_publicas" :key="indexRelacoesPublicas">
                                    <input
                                        :disabled="loading"
                                        :id="`relapu_${indexRelacoesPublicas}`"
                                        name="relacoes_publicas"
                                        :class="[ 'form-control radio-inline radio_lista radio',{ 'is-invalid': errors.has(`relacoes_publicas`) }]"                                        
                                        aria-describedby="input-1-live-feedback"
                                        data-vv-as="PUBLICIDADE E PROPAGANDA"
                                        type="checkbox"
                                        :value="relacoes_publicas.id"
                                        v-model="post.relacoes_publicas"
                                    ><label :key="`label_${indexRelacoesPublicas}`" :for="`relapu_${indexRelacoesPublicas}`" class="mr-2">{{ relacoes_publicas.descricao }}</label>
                                </span>
                            </div>
                        </div>

                        <div class="col-12 mt-5 mb-2 text-center" v-if="!this.form_jr">
                            <label for="ativo" label-class="font-weight-bold" style="font-size:20px !important; color:black;">CLIQUE NOS BOTÕES PARA ESCOLHER CATEGORIAS DE PRODUÇÃO EDITORIAL E PRODUÇÃO TRANSDISCIPLINAR EM COMUNICAÇÃO:</label><br />
                            <div class="switch-field-one" >
                                <span v-for="(producao_editorial, indexProdEdit) in producao_editorial" :key="indexProdEdit">
                                    <input
                                        :disabled="loading"
                                        :id="`prodedit_${indexProdEdit}`"
                                        name="producao_editorial"
                                        :class="[ 'form-control radio-inline radio_lista radio',{ 'is-invalid': errors.has(`producao_editorial`) }]"                                        
                                        aria-describedby="input-1-live-feedback"
                                        data-vv-as="PUBLICIDADE E PROPAGANDA"
                                        type="checkbox"
                                        :value="producao_editorial.id"
                                        v-model="post.producao_editorial"
                                    ><label :key="`label_${indexProdEdit}`" :for="`prodedit_${indexProdEdit}`" class="mr-2">{{ producao_editorial.descricao }}</label>
                                </span>
                            </div>
                        </div>

                        <div class="col-12 mt-5 mb-2 text-center" v-if="!this.form_jr">
                            <label for="ativo" label-class="font-weight-bold" style="font-size:20px !important; color:black;">CLIQUE NOS BOTÕES PARA ESCOLHER CATEGORIAS DE RADIO TV E INTERNET:</label><br />
                            <div class="switch-field-one" >
                                <span v-for="(radio_internet, indexRadioInternet) in radio_internet" :key="indexRadioInternet">
                                    <input
                                        :disabled="loading"
                                        :id="`ra_${indexRadioInternet}`"
                                        name="radio_internet"
                                        :class="[ 'form-control radio-inline radio_lista radio',{ 'is-invalid': errors.has(`radio_internet`) }]"                                        
                                        aria-describedby="input-1-live-feedback"
                                        data-vv-as="PUBLICIDADE E PROPAGANDA"
                                        type="checkbox"
                                        :value="radio_internet.id"
                                        v-model="post.radio_internet"
                                    ><label :key="`label_${indexRadioInternet}`" :for="`ra_${indexRadioInternet}`" class="mr-2">{{ radio_internet.descricao }}</label>
                                </span>
                            </div>
                        </div>

                    </b-row>
                </div>

                <div class="card-footer row">
                    <div class="col d-flex justify-content-end">
                    <b-button :disabled="loading" size="md" variant="outline-danger" class="align-self-end m-1" @click="back()">
                        Voltar
                    </b-button>

                    <b-button :disabled="loading" size="md" variant="outline-success" class="align-self-end m-1" @click="save()">
                        CADASTRAR
                    </b-button>
                    </div>
                </div>

            </div>
        </div>
    </div>
        <notifications group="submit" position="bottom center" width="600px" />

</div>

</template>

<script>
    import MixinsGlobal from  '../mixins/global-mixins'

      export default {
        props: ['user', 'form_jr'],
        mixins: [ MixinsGlobal],
        data() {
            return {
                loading: false,
                divisoes_tematicas: [],
                divisoes_tematicas_jr: [],
                cinema_audiovisual: [],
                jornalismo: [],
                publicidade_propaganda: [],
                relacoes_publicas: [],
                producao_editorial: [],
                radio_internet: [],
                estados: [],
                municipios: [],
                instituicoes: [],
                paises: [],
                titulacoes: [],
                loading: false,
                verify: null,
                post: {
                    id: null,
                    name: null,
                    email: null,
                    cpf: null,
                    telefone: null,
                    celular: null,
                    divisoes_tematicas: [],
                    divisoes_tematicas_jr: [],
                    instituicao_id: null,    
                    titulacao_id: null,            
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
            user(){
                if(this.user){
                    this.$forceUpdate()
                    this.post.id = this.user.id ? this.user.id : null
                    this.post.name = this.user.name ? this.user.name : null
                    this.post.email = this.user.email ? this.user.email : null 
                    this.post.cpf = this.user.cpf ? this.user.cpf : null
                    this.post.celular = this.user.celular ? this.user.celular : null
                    this.post.telefone = this.user.telefone ? this.user.telefone : null
                    this.post.instituicao_id = this.user && this.user.associado ? this.user.associado.instituicao_id : null
                    this.post.titulacao_id = this.user && this.user.associado ? this.user.associado.titulacao_id : null
                    this.post.enderecos = {
                        id: this.user && this.user.enderecos && this.user.enderecos[0] ? this.user.enderecos[0].id: null,
                        cep: this.user && this.user.enderecos && this.user.enderecos[0] ? this.user.enderecos[0].cep : null,
                        logradouro: this.user && this.user.enderecos && this.user.enderecos[0] ? this.user.enderecos[0].logradouro : null,
                        numero: this.user && this.user.enderecos && this.user.enderecos[0] ? this.user.enderecos[0].numero : null,
                        complemento: this.user && this.user.enderecos && this.user.enderecos[0] ? this.user.enderecos[0].complemento : null,
                        bairro: this.user && this.user.enderecos && this.user.enderecos[0] ? this.user.enderecos[0].bairro : null,
                        municipio: this.user && this.user.enderecos && this.user.enderecos[0] ? this.user.enderecos[0].municipio : null,
                        estado: this.user && this.user.enderecos && this.user.enderecos[0] ? this.user.enderecos[0].municipio.estado : null,
                    },
                    this.post.pais = this.user && this.user.enderecos && this.user.enderecos[0] ? this.user.enderecos[0].pais_id : null,
                    this.post.divisoes_tematicas = this.find_divisoes_tematicas,
                    this.post.divisoes_tematicas_jr = this.find_divisoes_tematicas_jr,
                    
                    this.post.cinema_audiovisual = this.find_cinema_audiovisual,
                    this.post.jornalismo = this.find_jornalismo,
                    this.post.publicidade_propaganda = this.find_publicidade_propaganda,
                    this.post.relacoes_publicas = this.find_relacoes_publicas,
                    this.post.producao_editorial = this.find_producao_editorial,
                    this.post.radio_internet = this.find_radio_internet,
                    this.post.junior = this.verify_avaliador_junior,
                    this.post.avaliador = this.verify_avaliador
                }
            },
        },
        computed: {
            verify_avaliador() {
                if(this.user && this.user.avaliador_expocom && this.user.avaliador_expocom.avaliador){
                    return 1
                }
                return !this.form_jr ? 1 : 0
            },
            verify_avaliador_junior() {
                if(this.user && this.user.avaliador_expocom && this.user.avaliador_expocom.avaliador_junior){
                    return 1
                }
                return this.form_jr ? 1 : 0
            },
            find_divisoes_tematicas() {
                return this.user && this.user.todos_divisoes_tematicas
                    ? this.user.todos_divisoes_tematicas.map(res => res.id) 
                    : []
            },
            find_divisoes_tematicas_jr() {
                return this.user && this.user.todos_divisoes_tematicas_jr
                    ? this.user.todos_divisoes_tematicas_jr.map(res => res.id) 
                    : []
            },
            find_cinema_audiovisual() {
                return this.user && this.user.todos_cinema_audiovisual
                    ? this.user.todos_cinema_audiovisual.map(res => res.id) 
                    : []
            },
            find_jornalismo() {
                return this.user && this.user.todos_jornalismo
                    ? this.user.todos_jornalismo.map(res => res.id) 
                    : []
            },
            find_publicidade_propaganda() {
                return this.user && this.user.todos_publicidade_propaganda
                    ? this.user.todos_publicidade_propaganda.map(res => res.id) 
                    : []
            },
            find_relacoes_publicas() {
                return this.user && this.user.todos_relacoes_publicas
                    ? this.user.todos_relacoes_publicas.map(res => res.id) 
                    : []
            },
            find_producao_editorial() {
                return this.user && this.user.todos_producao_editorial
                    ? this.user.todos_producao_editorial.map(res => res.id) 
                    : []
            },
            find_radio_internet() {
                return this.user && this.user.todos_radio_internet
                    ? this.user.todos_radio_internet.map(res => res.id) 
                    : []
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
            getDivisoesTematicas(){
                $.ajax({
                    method: "GET",
                    url: "get/divisoes-tematicas",
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
            getDivisoesTematicasJr(){
                $.ajax({
                    method: "GET",
                    url: "get/divisoes-tematicas-jr",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.divisoes_tematicas_jr = res
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
                this.loading = true
                
                if(this.form_jr == 1){
                    if(this.post.divisoes_tematicas && this.post.divisoes_tematicas.length == 0 && this.post.divisoes_tematicas_jr && this.post.divisoes_tematicas_jr.length == 0) {
                        this.$notify({
                            group: "submit",
                            title: "Erro",
                            text: 'Selecione pelo menos umas das áreas!',
                            type: "error"
                        })
                        this.loading = false
                        return
                    }
                }

                if(this.form_jr == 0){
                    if(
                        this.post.cinema_audiovisual && this.post.cinema_audiovisual.length == 0
                        && this.post.jornalismo && this.post.jornalismo.length == 0
                        && this.post.publicidade_propaganda && this.post.publicidade_propaganda.length == 0
                        && this.post.producao_editorial && this.post.producao_editorial.length == 0
                        && this.post.radio_internet && this.post.radio_internet.length == 0
                        && this.post.relacoes_publicas && this.post.relacoes_publicas.length == 0

                    
                    ) {
                        this.$notify({
                            group: "submit",
                            title: "Erro",
                            text: 'Selecione pelo menos uma categegoria!',
                            type: "error"
                        })
                        this.loading = false
                        return
                    }
                }

                await this.$validator.validateAll().then((valid) => {
                    if(valid) {
                        this.message('Aguarde...', 'Estamos salvando suas informações', 'info');

                        setTimeout(() => {
                            var dados = this.post;

                            $.ajax({
                                method: "POST",
                                url: "avaliador/save",
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

                                    setTimeout(() => {
                                        window.location.href = '/home';
                                    },2000)


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
            }
        },
        created() {
            this.getGeneros(),
            this.getTitulacoes(),
            this.getInstituicoes(),
            this.getEstados(),
            this.getDivisoesTematicas(),
            this.getDivisoesTematicasJr(),
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
