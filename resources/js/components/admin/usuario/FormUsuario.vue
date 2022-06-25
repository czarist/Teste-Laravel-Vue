<template>
    <b-modal id="usuarioModal" size="lg" no-close-on-backdrop>
        <template #modal-header="{ close }">
            <h5 v-if="post.id">Editar Usuário</h5>
            <h5 v-else>Cadastrar Usuário</h5>
            <b-button size="sm" variant="outline-danger" @click="close()">x</b-button>
        </template>
        <template>
            <b-row>
                <b-col cols="12" sm="6" lg="4">
                    <b-form-group label="Nome" label-class="font-weight-bold">
                        <b-form-input
                            name="name"
                            size="sm"
                            v-model="post.name"
                            type="text"
                            :disabled="loading"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`name`)}]"
                            v-validate="{ fullName: post.name }"
                            aria-describedby="input-1-live-feedback"
                            data-vv-as="name"
                        ></b-form-input>
                        <span v-show="errors.has(`name`)" class="invalid-feedback">
                            {{ errors.first(`name`) }}
                        </span>
                    </b-form-group>
                </b-col>

                <b-col>
                    <b-form-group label="E-mail" label-class="font-weight-bold" cols="12" sm="6" lg="4">
                        <b-form-input
                            name="email"
                            size="sm"
                            v-model="post.email"
                            type="text"
                            :disabled="loading"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`email`)}]"
                            aria-describedby="input-1-live-feedback"
                            data-vv-as="E-mail"
                            v-validate="{ email: true }"
                        ></b-form-input>
                        <span v-show="errors.has(`email`)" class="invalid-feedback">
                            {{ errors.first(`email`) }}
                        </span>
                    </b-form-group>
                </b-col>

                <b-col cols="12" sm="6" lg="4">
                    <b-form-group label="Senha" label-class="font-weight-bold">
                        <b-form-input
                            name="password"
                            size="sm"
                            v-model="post.password"
                            :disabled="loading"
                            :type="showPassaword"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`password`)}]"
                            aria-describedby="input-1-live-feedback"
                            data-vv-as="Senha"
                            v-validate="{ required: passRequired, min:6}"
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

                <b-col cols="12" sm="6" lg="4">
                    <b-form-group label="Data de nascimento" label-class="font-weight-bold">
                        <b-form-input
                            name="data_nascimento"
                            size="sm"
                            v-model="post.data_nascimento"
                            type="date"
                            :disabled="loading"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`data_nascimento`)}]"
                            aria-describedby="input-1-live-feedback"
                            data-vv-as="Data de nascimento"
                        ></b-form-input>
                        <span v-show="errors.has(`data_nascimento`)" class="invalid-feedback">
                            {{ errors.first(`data_nascimento`) }}
                        </span>
                    </b-form-group>
                </b-col>

                <b-col cols="12" sm="6" lg="4">
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

                <b-col cols="12" sm="6" lg="4" v-if="post.estrangeiro">
                    <b-form-group label="Passaporte" label-class="font-weight-bold">
                        <b-form-input
                            name="passaporte"
                            size="sm"
                            :disabled="loading"
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


                <b-col cols="12" sm="6" lg="4" v-if="!post.estrangeiro">
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

                <b-col cols="12" sm="6" lg="4" v-if="!post.estrangeiro">
                    <b-form-group label="RG" label-class="font-weight-bold">
                        <b-form-input
                            name="rg"
                            size="sm"
                            :disabled="loading"
                            v-model="post.rg"
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

                <b-col cols="12" sm="6" lg="4" v-if="!post.estrangeiro">
                    <b-form-group label="Orgão expedidor" label-class="font-weight-bold">
                        <b-form-input
                            name="orgao_expedidor"
                            size="sm"
                            :disabled="loading"
                            v-model="post.orgao_expedidor"
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

                <b-col cols="12" sm="6" lg="4">
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

                <b-col cols="12" sm="6" lg="4">
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

                <b-col cols="12" sm="6" lg="4">
                    <b-form-group label="Gênero" label-class="font-weight-bold">
                        <b-form-select
                            :disabled="loading"
                            name="generos"
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

                <b-col cols="12" sm="6" lg="4">
                    <b-form-group
                        label="Acesso ao sistema"
                        label-class="font-weight-bold"
                        >
                        <b-form-radio-group
                            :disabled="loading"
                            v-model="post.ativo"
                            :options="options"
                            :button-variant="`outline-primary`" 
                            size="sm"
                            v-validate="{ required: post.ativo == 0 ? true : false }"
                            name="ativo"
                            buttons
                        ></b-form-radio-group>
                        <span v-show="errors.has(`ativo`)" class="invalid-feedback d-block">
                            {{ errors.first(`ativo`) }}
                        </span>
                    </b-form-group>
                </b-col>
            </b-row>
            <hr/>
            <b-row>

                <b-col cols="12" sm="6" lg="6">
                    <b-form-group label="Instituição" label-class="font-weight-bold">
                        <b-form-select
                            :disabled="loading"
                            name="instituicao"
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

                <b-col cols="12" sm="6" lg="4">
                    <b-form-group label="Anuidade" label-class="font-weight-bold">
                        <b-form-input
                            name="anuidade"
                            size="sm"
                            v-model="post.anuidade"
                            type="text"
                            :disabled="loading"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`anuidade`)}]"
                            aria-describedby="input-1-live-feedback"
                            data-vv-as="anuidade"
                        ></b-form-input>
                        <span v-show="errors.has(`anuidade`)" class="invalid-feedback">
                            {{ errors.first(`anuidade`) }}
                        </span>
                    </b-form-group>
                </b-col>

                <b-col cols="12" sm="6" lg="4">
                    <b-form-group label="Número do Sócio" label-class="font-weight-bold">
                        <b-form-input
                            name="numero_socio"
                            size="sm"
                            v-model="post.numero_socio"
                            type="text"
                            :disabled="loading"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`numero_socio`)}]"
                            aria-describedby="input-1-live-feedback"
                            data-vv-as="numero_socio"
                        ></b-form-input>
                        <span v-show="errors.has(`numero_socio`)" class="invalid-feedback">
                            {{ errors.first(`numero_socio`) }}
                        </span>
                    </b-form-group>
                </b-col>

                <b-col cols="12" sm="6" lg="4">
                    <b-form-group label="Obs Insentamos" label-class="font-weight-bold">
                        <b-form-input
                            name="obs_isentamos"
                            size="sm"
                            v-model="post.obs_isentamos"
                            type="text"
                            :disabled="loading"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`obs_isentamos`)}]"
                            aria-describedby="input-1-live-feedback"
                            data-vv-as="obs_isentamos"
                        ></b-form-input>
                        <span v-show="errors.has(`obs_isentamos`)" class="invalid-feedback">
                            {{ errors.first(`obs_isentamos`) }}
                        </span>
                    </b-form-group>
                </b-col>

            </b-row>

            <hr/>
           <div class="row">
                <div class="col-12 d-flex justify-content-between">
                    <label>Endereços</label>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group ">
                                <label for="">CEP</label>
                                <b-form-input
                                    size="sm"
                                    v-validate="{ min: 9 }"
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
                                <label for="">logradouro</label>
                                <b-form-input
                                    size="sm"
                                    :name="`logradouro`"
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
                            <label>Estado</label>
                            <v-select
                                class="flex-fill"
                                :options="estados"
                                data-vv-as="estado"
                                :selectOnTab="true"
                                v-model="post.enderecos.estado"
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
                            <label>Município</label>
                            <v-select
                                class="flex-fill"
                                :name="`municipio`"
                                :disabled="loading"
                                :options="municipios"
                                :selectOnTab="false"
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
                                v-model="post.enderecos.pais"
                                type="text"
                                :disabled="loading"
                                :class="[
                                'form-control form-control-sm',
                                { 'is-invalid': errors.has(`pais`) },
                                ]"
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
            </div>
            <hr/>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="todos_isencoes_id">Tipo de Isenção Nacional:</label><br />
                        <div class="btn-group" style="margin-bottom:-10px;">
                            <div class="switch-field" >
                                <span v-for="(isencao_tipo, index) in tipos_isencoes" :key="index">
                                    <input
                                        :disabled="loading"
                                        :id="`todos_isencoes_${index}`"
                                        class="form-control radio-inline radio_lista radio"
                                        name="tipos_isencoes[]"
                                        type="checkbox"
                                        :value="isencao_tipo.id"
                                        v-model="post.todos_isencoes_id"
                                    ><label :key="`label_${index}`" :for="`todos_isencoes_${index}`" class="mr-2">{{ isencao_tipo.descricao }}</label>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="todos_tipos_id">Tipo de Acesso:</label><br />
                        <div class="btn-group" style="margin-bottom:-10px;">
                            <div class="switch-field" >
                                <span v-for="(userType, index) in usersTypes" :key="index">
                                    <input
                                        :disabled="loading"
                                        :id="`todos_tipos_${index}`"
                                        class="form-control radio-inline radio_lista radio"
                                        name="usersTypes[]"
                                        type="checkbox"
                                        :value="userType.id"
                                        v-model="post.todos_tipos_id"
                                    ><label :key="`label_${index}`" :for="`todos_tipos_${index}`" class="mr-2">{{ userType.descricao }}</label>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row" v-if="post.todos_tipos_id != 1">
                <div class="col-12">
                    <label for="ativo">Telas Liberadas:</label><br />
                    <div class="switch-field-one" >
                        <span v-for="(acesso, index) in acessos" :key="index">
                            <input
                                :disabled="loading"
                                :id="`ace_${index}`"
                                class="form-control radio-inline radio_lista radio"
                                name="acessos[]"
                                type="checkbox"
                                :value="acesso.id"
                                v-model="post.acessos"
                            ><label :key="`label_${index}`" :for="`ace_${index}`" class="mr-2">{{ acesso.pagina }}</label>
                        </span>
                    </div>
                </div>
            </div>
            <div v-else>
                <div class="col-12">
                    <div class="row mt-2 alert alert-warning">
                        <span class="">Atenção! esse usuário pode ter acesso a todo o sistema.</span>
                    </div>
                </div>
            </div>
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
        props: ['selected', 'id'],
        mixins: [
            MixinsGlobal
        ],
        data() {
            return {
                loading: false,
                acessos: [],
                estados: [],
                municipios: [],
                generos: [],
                usersTypes: [],
                tipos_isencoes: [],
                location: null,
                verify: null,
                paises: [],
                titulacoes: [],
                instituicoes: [],
                titulacoes: [],
                showHidePasswod: false,
                showPassaword: "password",
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
                    instituicao_id: null,    
                    titulacao_id: null,            
                    anuidade: null,
                    numero_socio: null,
                    obs_isentamos: null,
                    todos_tipos_id: 3,
                    todos_isencoes_id: null,
                    ativo: 0,
                    acessos: [],
                    enderecos: {
                        id: null,
                        cep: null,
                        logradouro: null,
                        numero : null,
                        complemento: null,
                        bairro: null, 
                        municipio: null,
                        estado: null,
                        pais: null
                    },
                    _method: 'post'
                },
                options: [
                    { text: 'Não', value: 0 },
                    { text: 'Sim', value: 1 },
                ],
            }
        },
        watch: {    
            selected() {
                if(this.selected) {
                    this.$forceUpdate()
                    this.post.id = this.selected && this.selected.id
                    this.post.name = this.selected && this.selected.name
                    this.post.email = this.selected && this.selected.email
                    this.post.todos_tipos_id = this.filterTipoUser
                    this.post.todos_isencoes_id = this.filterTipoIsencao
                    this.post.ativo = this.selected && this.selected.ativo
                    this.post.acessos = this.access
                    this.post._method = 'put'
                    this.post.data_nascimento = this.selected && this.selected.data_nascimento
                    this.post.orgao_expedidor = this.selected && this.selected.orgao_expedidor
                    this.post.cpf = this.selected && this.selected.cpf
                    this.post.rg = this.selected && this.selected.rg
                    this.post.telefone = this.selected && this.selected.telefone
                    this.post.celular = this.selected && this.selected.celular
                    this.post.sexo_id = this.selected && this.selected.sexo_id
                    this.post.anuidade = this.selected && this.selected.associado ? this.selected.associado.anuidade : null
                    this.post.numero_socio = this.selected && this.selected.associado ? this.selected.associado.numero_socio : null
                    this.post.obs_isentamos = this.selected && this.selected.associado ? this.selected.associado.obs_isentamos : null
                    this.post.instituicao_id = this.selected.associado ? this.selected.associado.instituicao_id : null
                    this.post.titulacao_id = this.selected.associado ? this.selected.associado.titulacao_id : null

                    this.post.enderecos = {
                        id: this.selected && this.selected.enderecos && this.selected.enderecos[0] ? this.selected.enderecos[0].id : null,
                        cep: this.selected && this.selected.enderecos && this.selected.enderecos[0] ? this.selected.enderecos[0].cep : null,
                        logradouro: this.selected && this.selected.enderecos && this.selected.enderecos[0] ? this.selected.enderecos[0].logradouro : null,
                        numero: this.selected && this.selected.enderecos && this.selected.enderecos[0] ? this.selected.enderecos[0].numero : null,
                        complemento: this.selected && this.selected.enderecos && this.selected.enderecos[0] ? this.selected.enderecos[0].complemento : null,
                        bairro: this.selected && this.selected.enderecos && this.selected.enderecos[0] ? this.selected.enderecos[0].bairro : null,
                        pais: this.selected && this.selected.enderecos && this.selected.enderecos[0] ? this.selected.enderecos[0].pais_id : null,
                        municipio: this.selected && this.selected.enderecos && this.selected.enderecos[0] && this.selected.enderecos[0].municipio ? this.selected.enderecos[0].municipio : null,
                        estado: this.selected && this.selected.enderecos && this.selected.enderecos[0] && this.selected.enderecos[0].municipio ? this.selected.enderecos[0].municipio.estado: null,
                    }
                } else {
                    this.clear()
                }
            },
            showHidePasswod(){
                this.showPassaword = this.showHidePasswod == true ? 'text' : 'password'; 
            }
        },
        computed: {
            access() {
                return this.selected && this.selected.acessos 
                    ? this.selected.acessos.map(res => res.id) 
                    : []
            },
            filterTipoUser() {
                return this.selected && this.selected.todos_tipos 
                    ? this.selected.todos_tipos.map(res => res.id) 
                    : []
            },
            filterTipoIsencao() {
                return this.selected && this.selected.todos_tipos_isencao 
                    ? this.selected.todos_tipos_isencao.map(res => res.id) 
                    : []
            },
            passRequired() {
                return this.post && this.post.id ? false : true
            },
            
            url() {
                return this.post && this.post.id ? `/${this.post.id}` : ''
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
                            this.post.enderecos.municipio = this.municipios.find(municipio => municipio.nome == this.selected.enderecos[0].municipio.nome)
                            this.$validator.reset(`municipio`)
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
                            axios.post(`${process.env.MIX_BASE_URL}/admin/usuarios${this.url}`, this.post).then( res => {
                                this.clear()
                                if(res.status == 201) {
                                    this.loading = false
                                    this.$emit('store', res.data.response)
                                }
                                
                                if (res.status == 200) {
                                    this.loading = false
                                    this.$emit('update', res.data.response)
                                }
                                this.message('Sucesso', res.status == 201 ? 'Usuário cadastrado.' : 'Usuário atualizado.', 'success');
                               
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
                this.post.name = null
                this.post.email = null
                this.post.todos_tipos_id = 3
                this.post.todos_isencoes_id = null
                this.post.ativo = 0
                this.post.acessos = [],
                this.post._method = 'post'
                this.post.data_nascimento = null
                this.post.orgao_expedidor = null
                this.post.cpf = null
                this.post.rg = null
                this.post.telefone = null
                this.post.celular = null
                this.post.sexo_id = null
                this.post.anuidade = null
                this.post.numero_socio = null
                this.post.obs_isentamos = null
                this.post.instituicao_id = null
                this.post.titulacao_id = null
                this.post.enderecos = {
                    id: null,
                    cep: null,
                    logradouro: null,
                    numero : null,
                    complemento: null,
                    bairro: null, 
                    municipio: null,
                    estado: null,
                    pais: null
                },
                this.$validator.reset('name')
                this.$validator.reset('email')
            }
        },
        created() {
            axios.get(process.env.MIX_BASE_URL+'/get/tiposusuarios').then(res => {
                this.usersTypes = res.data
            })

            axios.get(process.env.MIX_BASE_URL+'/get/tipo_isencao').then(res => {
                this.tipos_isencoes = res.data
            })


            axios.get(process.env.MIX_BASE_URL+'/get/acessos').then(res => {
               
                this.acessos = res.data
            })

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

<style scoped>
    ::v-deep .modal-backdrop {
        opacity: 0.5 !important;
    }
</style>