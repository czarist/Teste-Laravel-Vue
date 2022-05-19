<template>

<div v-if="now == false">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <h1>Encontro Inter-regiões - Centro-Oeste</h1>
                    <h2>FICHA DE INSCRIÇÃO</h2>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header text-center">
                    <h2> DADOS PESSOAIS</h2>
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
                                    v-validate="{ required: true}"
                                    type="text"
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
                                    type="text"
                                    v-validate="{ required: true}"
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
                    </b-row> 
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header text-center">
                    <h2>DADOS ACADÊMICOS</h2>
                </div>

                <div class="card-body">

                    <b-row>
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
                                    {{ instituicao.instituicao }} - {{ instituicao.sigla_instituicao }}
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
                                    :disabled="user && user.pago_regional_centrooeste_2022 && post && post.titulacao_id != null ? true : loading" 
                                    name="titulacao"
                                    v-validate="{ required: true }"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`titulacao`)}]"
                                    size="sm"
                                    data-vv-as="titulação"
                                    class="form-control form-control-sm"
                                    v-model="post.titulacao_id"
                                >
                                    <option :value="null">Selecione a Titulação</option>
                                    <option value="1">Estudante de Graduação</option>
                                    <option value="2">Bacharel</option>
                                    <option value="3">Livre Docente</option>
                                    <option value="4">Mestrando</option>
                                    <option value="5">Doutorando</option>
                                    <option value="6">Mestre</option>
                                    <option value="7">Doutor</option>
                                    <option value="8">Cursando Especialização</option>
                                    <option value="9">Especialista</option>
                                    <option value="10">Licenciado</option>
                                </b-form-select>
                                <span class="invalid-feedback">
                                Atenção: os recém-graduados (2021 - 2022) deverão selecionar a titulação "Estudante de graduação"
                                </span>

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
                    <h2>DADOS ESPECIAIS</h2>
                </div>

                <div class="card-body">
                    <b-row>
                        <b-col cols="12" sm="3" lg="3" size="lg">
                            <b-form-group 
                                size="lg"
                                label="Portador de necessidades especiais?"
                                label-class="font-weight-bold"
                            >
                                <b-form-radio-group
                                    :disabled="loading"
                                    v-model="port_nece_if"
                                    :options="port_nece"
                                    :button-variant="`outline-primary`" 
                                    size="sm"
                                    name="port_nece"
                                    buttons
                                ></b-form-radio-group>
                                <span v-show="errors.has(`port_nece`)" class="invalid-feedback d-block">
                                    {{ errors.first(`port_nece`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="3" lg="3" size="lg" v-if="port_nece_if">
                            <b-form-group label="Se sim qual?" label-class="font-weight-bold">
                                <b-form-select
                                    :disabled="loading"
                                    name="qual"
                                    v-validate="{ required: true }"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`qual`)}]"
                                    size="sm"
                                    data-vv-as="Qual necessidade especial?"
                                    class="form-control form-control-sm"
                                    v-model="qual"
                                >
                                <option value="null">Selecione</option>
                                <option value="Auditiva">Auditiva</option>
                                <option value="Visual">Visual</option>
                                <option value="Motora">Motora</option>
                                <option value="Outra">Outra</option>

                                </b-form-select>
                                <span v-show="errors.has(`qual`)" class="invalid-feedback">
                                    {{ errors.first(`qual`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="3" lg="3" v-if="qual == 'Outra'">
                            <b-form-group label="Se outra, descrever" label-class="font-weight-bold">
                                <b-form-input
                                    name="outra"
                                    size="sm"
                                    v-model="post.outra_necessidade"
                                    type="text"
                                    :disabled="loading"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`outra`)}]"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="Se outra, descrever"
                                ></b-form-input>
                                <span v-show="errors.has(`outra`)" class="invalid-feedback">
                                    {{ errors.first(`outra`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="3" lg="3" size="lg">
                            <b-form-group 
                                size="lg"
                                label="Guardador de Sábado por convicção religiosa?"
                                label-class="font-weight-bold"
                            >
                                <b-form-radio-group
                                    :disabled="loading"
                                    v-model="post.guard_sab"
                                    :options="guard_sab"
                                    :button-variant="`outline-primary`" 
                                    size="sm"
                                    name="Guardador de Sábado"
                                    buttons
                                ></b-form-radio-group>
                                <span v-show="errors.has(`guard_sab`)" class="invalid-feedback d-block">
                                    {{ errors.first(`guard_sab`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                    </b-row>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header text-center">
                    <h2>ENDEREÇO</h2>
                </div>

                <div class="card-body">
                    <b-row>
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
                                    v-model="post.endereco.cep"
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
                                    v-model="post.endereco.logradouro"
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
                                    v-model="post.endereco.numero"
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
                                    v-model="post.endereco.complemento"
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
                                    v-model="post.endereco.bairro"
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
                                v-model="post.endereco.estado"
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
                                <span v-show="errors.has(`estado`)" class="invalid-feedback d-block">
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
                                v-model="post.endereco.municipio"
                                label="nome"
                                data-vv-as="municipio"
                                :class="{ 'v-select-invalid': errors.has(`municipio`) }"
                                ></v-select>
                                <span v-show="errors.has(`municipio`)" class="invalid-feedback d-block">
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
            </div>

            <div class="card mt-3">
                <div class="card-header text-center">
                    <h2>CATEGORIA E TAXA DE INSCRIÇÃO (R$)</h2>
                </div>

                <div class="card-body">
                    <b-row>
                        <b-col cols="12" sm="12" lg="12" size="lg" v-if="!user.pago_regional_centrooeste_2022">

                            <div class="table-responsive scroll" ref="scroll" v-show="!loading && produtosRegionais.length > 0">
                                <table class="table table-sm table-striped table-hover table-bordered" v-if="user">
                                    <thead>
                                        <tr>
                                            <th class="align-middle text-center" width="10%">SELECIONE</th>
                                            <th class="align-middle text-center" width="60%">CATEGORIAS</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(produtoRegional, index) in produtosRegionais" :key="index">
                                            <td 
                                                class="align-middle text-center"
                                                
                                            >
                                                <b-form-checkbox
                                                    :id="produtoRegional.id+'_'+index"
                                                    v-model="post.taxa_inscricao"
                                                    name="taxa"
                                                    :value="produtoRegional"
                                                    :disabled="loading"
                                                    v-validate="{ required: true }"
                                                    >
                                                </b-form-checkbox>
                                            </td>
                                            <td class="align-middle text-center">{{ produtoRegional ? produtoRegional.nome : "NI" }} - R${{ produtoRegional ? produtoRegional.valor : "NI" }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <span v-show="errors.has(`taxa`)" class="invalid-feedback text-center">
                                {{ errors.first(`taxa`) }}
                            </span>
                        </b-col>

                        <b-col cols="12" sm="12" lg="12" size="lg" v-if="user.pago_regional_centrooeste_2022 == true">
                            <div>
                                <b-alert show variant="success">
                                    <h4 class="alert-heading">Você já esta inscrito no Reginal Centro-Oeste!</h4>
                                    <p>
                                    Já foi inscrito pelo nosso sistema para o Regional Centro-Oeste 2022.
                                    </p>
                                </b-alert>
                            </div>
                        </b-col>

                        <b-col cols="12" sm="12" lg="12" size="lg">
                            <div class="table-responsive scroll" ref="scroll" v-show="!loading && produtosRegionais.length > 0">
                                <table class="table table-sm table-striped table-hover table-bordered" v-if="user">
                                    <thead>
                                        <tr>
                                            <th class="align-middle text-center" width="60%">CATEGORIAS</th>
                                            <th class="align-middle text-center" width="10%">De 14/03 a 24/04/2022</th>
                                            <th class="align-middle text-center" width="10%">De 25/04 a 13/05/2022</th>
                                            <th class="align-middle text-center" width="10%">De 14/05 a 24/05/2022</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr >
                                            <td class="align-middle text-center">Estudante de graduação e recém-graduado (2021-2022) ²</td>
                                            <td class="align-middle text-center">R$40,00</td>
                                            <td class="align-middle text-center">R$50,00</td>
                                            <td class="align-middle text-center">R$65,00</td>
                                        </tr>
                                        <tr >
                                            <td class="align-middle text-center">Sócio da Intercom³</td>
                                            <td class="align-middle text-center text-black">isento</td>
                                            <td class="align-middle text-center">isento</td>
                                            <td class="align-middle text-center">isento</td>
                                        </tr>
                                        <tr >
                                            <td class="align-middle text-center">Estudante de pós-graduação</td>
                                            <td class="align-middle text-center">R$100,00</td>
                                            <td class="align-middle text-center">R$145,00</td>
                                            <td class="align-middle text-center">R$165,00</td>
                                        </tr>
                                        <tr >
                                            <td class="align-middle text-center">Professores e pesquisadores</td>
                                            <td class="align-middle text-center">R$220,00</td>
                                            <td class="align-middle text-center">R$225,00</td>
                                            <td class="align-middle text-center">R$275,00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </b-col>

                        <b-col cols="12" sm="12" lg="12" size="lg">
                            <div >
                                <p> ¹ A inscrição no congresso será aceita até o limite da capacidade de acomodação dos participantes nos locais do congresso. Recomenda-se a inscrição antecipada, sobretudo para os que pretendem apresentar trabalhos.
                                    ² Na categoria "recém-graduados", somente é permitida a submissão de trabalhos para o Expocom (caso seja aluno líder) e para o Intercom Jr.
                                    ³ Associados que quitaram a anuidade 2022 estão isentos do pagamento da taxa de inscrição
                                </p> <br>

                                <h3 class="text-center">ATENÇÃO</h3>
                                <p> • Não serão realizadas inscrições no local.</p>
                                <p> • Não haverá restituição da taxa de inscrição.</p>
                                <p> • Os certificados de participação e apresentação de trabalhos serão online. Após o evento e a comprovação da presença do participante, o certificado será liberado na área reservada do inscrito para impressão.</p>
                            </div>
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

                            <div v-if="user.anuidade_2022 == false">
                                <b-button
                                    v-if="user.pago_regional_centrooeste_2022 == false"
                                    :disabled="user && user.pago_regional_centrooeste_2022 ? true : loading" 
                                    size="md" 
                                    variant="outline-success" 
                                    class="m-1" 
                                    @click="pagar(post)"
                                >
                                    Método de Pagamento
                                </b-button>
                            </div>

                            <div v-else>
                                <b-button
                                    :disabled="user && user.pago_regional_centrooeste_2022 ? true : loading" 
                                    size="md" 
                                    variant="outline-success" 
                                    class="m-1" 
                                    @click="isento(post)"
                                >
                                    Se inscrever como isento
                                </b-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <pagar-modal :selectedPagar="selectedPagar"></pagar-modal>
    <notifications group="submit" position="center bottom" width="700px" />
</div>

<div v-else class="text-center">
    <h1>Prazo para inscrição encerrado</h1>
</div>

</template>

<script>
    import debounce from 'debounce'
    import moment from 'moment'
    import MixinsGlobal from  '../../mixins/global-mixins'

      export default {
        props: ['user' , 'regiao'],
        mixins: [ MixinsGlobal],
        components: {
            'pagar-modal': () => import('../PagarModal'),
        },
        data() {
            return {
                loading: false,
                baseUrl: process.env.MIX_BASE_URL,
                now: moment().format('L') >= '05/25/2022' ? true : false,
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
                produtosRegionais: [],               
                loading: false,
                verify: null,
                post: {
                    id: null,
                    name: null,
                    email: null,
                    estrangeiro: 0,
                    anuidade2022: 1,
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
                port_nece_if: false,
                qual: false,
                outra_necessidade: false,
                options: [
                    { text: 'Não', value: 0 },
                    { text: 'Sim', value: 1 },
                ],
                port_nece: [
                    { text: 'Não', value: 0 },
                    { text: 'Sim', value: 1 },
                ],
                guard_sab: [
                    { text: 'Não', value: 0 },
                    { text: 'Sim', value: 1 },
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
                    this.post.titulacao_id = this.user && this.user.regional_centrooeste ? this.user.regional_centrooeste.categoria_inscricao : null

                    this.post.guard_sab = this.user && this.user.regional_centrooeste ? this.user.regional_centrooeste.guardador_sabado : null
                    this.post.port_nece = this.user && this.user.regional_centrooeste ? this.user.regional_centrooeste.port_nece_espe : null
                    this.post.qual = this.user && this.user.regional_centrooeste ? this.user.regional_centrooeste.port_nece_espe_qual : null
                    this.post.outra_necessidade = this.user && this.user.regional_centrooeste ? this.user.regional_centrooeste.port_nece_espe_outra : null
                    this.port_nece_if = this.post.port_nece == 1 ? 1 : 0
                    this.qual = this.post.qual ? this.post.qual : null

                    this.post.regiao = this.regiao ? this.regiao : null
                    this.post.ativo = this.user.ativo ? this.user.ativo : null,
                    this.post.endereco = {
                        id: this.user && this.user.enderecos && this.user.enderecos[0] 
                            ? this.user.enderecos[0].id
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
            },
            'port_nece_if': function(val){
                if(val == 1){
                    this.post.port_nece = 1
                }
            },
            'qual': function(val){
                if(val){
                    this.post.qual = val
                }
            },
        },
        computed: {
            passRequired() {
                return this.post && this.post.id ? false : true
            },
            
        },
        methods: {  
            async getEstados(){
                let urlgetEstados = this.baseUrl+"/get/estados";
                await $.ajax({
                    method: "GET",
                    url: urlgetEstados,
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
            getMunicipios() {
                if(this.post.endereco && this.post.endereco.estado) {
                    let urlgetMunicipios = this.baseUrl+`/get/municipios/${this.post.endereco.estado.id}`;

                    $.ajax({
                        method: "GET",
                        url: urlgetMunicipios,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        dataType: 'json',
                        success: (res) => {
                            this.municipios = res
                            if(this.selected && this.selected.enderecos) {
                                this.post.endereco.municipio = this.municipios.find(municipio => municipio.nome == this.selected.enderecos.municipio.nome)
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
                if(this.post.endereco.cep.length > 8) {
                    await fetch(`https://viacep.com.br/ws/${this.post.endereco.cep}/json`).then(res => res.json())
                        .then(res => {
                            this.post.endereco = {
                                cep: this.post.endereco.cep,
                                logradouro: res.logradouro,
                                bairro: res.bairro,
                                estado: this.estados.find(uf => uf.sigla == res.uf),
                                municipio: null,
                                id: this.post.endereco.id,
                                numero: this.post.endereco.numero,
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
                        this.post.endereco.municipio = this.municipios.find(municipio => municipio.nome == this.location)
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
                let urlPagamento = this.baseUrl+"/pagseguro/pagamento";
                await $.ajax({
                    method: "GET",
                    url: urlPagamento,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        PagSeguroDirectPayment.setSessionId(res.id);
                        this.sessions_pagseguro = res;
                    },
                    error: (res) => {
                    }
                });
            },
            getGeneros(){
                let urlgetGeneros = this.baseUrl+"/get/tiposexo";
                $.ajax({
                    method: "GET",
                    url: urlgetGeneros,
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
            getInstituicoes(){
                let urlgetInstituicoes = this.baseUrl+"/get/instituicoes";
                $.ajax({
                    method: "GET",
                    url: urlgetInstituicoes,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.instituicoes = res
                    },
                    error: (res) => {
                        
                    }
                }); 
            },
            async getProdutosRegionais() {
                let urlgetProdutosRegionais = this.baseUrl+"/get/produtos-regionais-centrooeste";

                await $.ajax({
                    method: "GET",
                    url: urlgetProdutosRegionais,
                    headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    dataType: "json",
                    success: (res) => {
                    this.produtosRegionais = res;
                    },
                    error: (res) => {
                    console.log(res);
                    },
                });
            },

            async save() {
                this.loading = true
                await this.$validator.validateAll().then((valid) => {
                    
                    if(valid) {
                        
                        if(this.post && this.post.taxa_inscricao && this.post.taxa_inscricao.id == 4 && this.user.anuidade_2022 == false){
                            this.loading = false
                            this.message('Sócio da Intercom', 'Precisar ser filiado e estar com a anuidade de 2022 em dia, troque a categoria para prosseguir', 'error');
                        } else{

                            this.message('Aguarde...', 'Estamos salvando suas informações', 'info');

                            setTimeout(() => {
                                var dados = this.post;

                                let urlSave = this.baseUrl+"/regional/centrooeste/save";

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
            async isento(post){
                this.loading = true
                await this.$validator.validateAll().then((valid) => {
                    if(valid) {

                        this.message('Aguarde...', 'Estamos salvando suas informações', 'info');
                        this.save()

                        setTimeout(() => {
                            window.location.href = this.baseUrl;
                        },4000)


                    } else {
                            this.loading = false
                            this.message('Campos Obrigatórios', 'Preencha todos os campos obrigatórios', 'error');
                    }
                })
            }
        },
        created() {
            this.getGeneros(),
            this.getInstituicoes(),
            this.getEstados(),
            this.getProdutosRegionais(),
            setTimeout(() => {
                this.pagamento()
            },3000)
        },
    }
</script>
