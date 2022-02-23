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
                    <b-form-group label="E-mail" label-class="font-weight-bold" cols="12" sm="6" lg="4">
                        <b-form-input
                            name="email"
                            size="sm"
                            v-model="post.email"
                            type="text"
                            :disabled="loading"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`email`)}]"
                            v-validate="{ required: true, email: true, emailCheck: post.id }"
                            aria-describedby="input-1-live-feedback"
                            data-vv-as="E-mail"
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

                <b-col cols="12" sm="6" lg="4">
                    <b-form-group label="Data de nascimento" label-class="font-weight-bold">
                        <b-form-input
                            name="name"
                            size="sm"
                            v-model="post.name"
                            type="date"
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

                <b-col cols="12" sm="6" lg="4">
                    <b-form-group
                        label="Estrangeiro"
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

                 <b-col cols="12" sm="6" lg="4">
                    <b-form-group label="CNPJ" label-class="font-weight-bold">
                        <b-form-input
                            name="cnpj_cpf"
                            size="sm"
                            :disabled="loading"
                            v-model="post.cnpj_cpf"
                            type="text"
                            v-mask="['###.###.###-##', '##.###.###/####-##']"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`cnpj_cpf`)}]"
                            v-validate="{ required: true }"
                            aria-describedby="input-1-live-feedback"
                            data-vv-as="CNPJ/CPF"
                        ></b-form-input>
                        <span v-show="errors.has(`cnpj_cpf`)" class="invalid-feedback">
                            {{ errors.first(`cnpj_cpf`) }}
                        </span>
                    </b-form-group>
                </b-col>

                <b-col cols="12" sm="6" lg="4">
                    <b-form-group label="RG" label-class="font-weight-bold">
                        <b-form-input
                            name="cnpj_cpf"
                            size="sm"
                            :disabled="loading"
                            v-model="post.cnpj_cpf"
                            type="text"
                            v-mask="['###.###.###-##', '##.###.###/####-##']"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`cnpj_cpf`)}]"
                            v-validate="{ required: true }"
                            aria-describedby="input-1-live-feedback"
                            data-vv-as="CNPJ/CPF"
                        ></b-form-input>
                        <span v-show="errors.has(`cnpj_cpf`)" class="invalid-feedback">
                            {{ errors.first(`cnpj_cpf`) }}
                        </span>
                    </b-form-group>
                </b-col>

                <b-col cols="12" sm="6" lg="4">
                    <b-form-group label="Orgão expedidor" label-class="font-weight-bold">
                        <b-form-input
                            name="cnpj_cpf"
                            size="sm"
                            :disabled="loading"
                            v-model="post.cnpj_cpf"
                            type="text"
                            v-mask="['###.###.###-##', '##.###.###/####-##']"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`cnpj_cpf`)}]"
                            v-validate="{ required: true }"
                            aria-describedby="input-1-live-feedback"
                            data-vv-as="CNPJ/CPF"
                        ></b-form-input>
                        <span v-show="errors.has(`cnpj_cpf`)" class="invalid-feedback">
                            {{ errors.first(`cnpj_cpf`) }}
                        </span>
                    </b-form-group>
                </b-col>

                <b-col cols="12" sm="6" lg="4">
                    <b-form-group label="Telefone" label-class="font-weight-bold">
                        <b-form-input
                            name="cnpj_cpf"
                            size="sm"
                            :disabled="loading"
                            v-model="post.cnpj_cpf"
                            type="text"
                            v-mask="['###.###.###-##', '##.###.###/####-##']"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`cnpj_cpf`)}]"
                            v-validate="{ required: true }"
                            aria-describedby="input-1-live-feedback"
                            data-vv-as="CNPJ/CPF"
                        ></b-form-input>
                        <span v-show="errors.has(`cnpj_cpf`)" class="invalid-feedback">
                            {{ errors.first(`cnpj_cpf`) }}
                        </span>
                    </b-form-group>
                </b-col>

                <b-col cols="12" sm="6" lg="4">
                    <b-form-group label="Celular" label-class="font-weight-bold">
                        <b-form-input
                            name="cnpj_cpf"
                            size="sm"
                            :disabled="loading"
                            v-model="post.cnpj_cpf"
                            type="text"
                            v-mask="['###.###.###-##', '##.###.###/####-##']"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`cnpj_cpf`)}]"
                            v-validate="{ required: true }"
                            aria-describedby="input-1-live-feedback"
                            data-vv-as="CNPJ/CPF"
                        ></b-form-input>
                        <span v-show="errors.has(`cnpj_cpf`)" class="invalid-feedback">
                            {{ errors.first(`cnpj_cpf`) }}
                        </span>
                    </b-form-group>
                </b-col>

                <div class="form-group col-12 col-md-6 col-lg-4">
                    <label>Sexo</label>
                    <v-select
                        class="flex-fill"
                        :options="estados"
                        data-vv-as="estado"
                        :selectOnTab="true"
                        v-model="post.sexo"
                        v-validate="{ required: true }"
                        :disabled="loading"
                        :class="[ {'v-select-invalid': errors.has(`estado${indice}`)}]"        
                        label="sigla"
                        @input="getMunicipios(indice)"
                        :name="`estado${indice}`"
                        >
                        <template v-slot:no-options="{ search, searching }">
                            <template v-if="searching">
                                Nada encontrado com <em>{{ search }}</em>.
                            </template>
                            <em style="opacity: 0.5;" v-else>Começe a digitar algo.</em>
                        </template>
                    </v-select>
                    <span v-show="errors.has(`estado${indice}`)" class="v-select-invalid-feedback">
                        {{ errors.first(`estado${indice}`) }}
                    </span>
                </div>

                <div class="form-group col-12 col-md-6 col-lg-4">
                    <label>Instituição</label>
                    <v-select
                        class="flex-fill"
                        :options="estados"
                        data-vv-as="estado"
                        :selectOnTab="true"
                        v-model="post.sexo"
                        v-validate="{ required: true }"
                        :disabled="loading"
                        :class="[ {'v-select-invalid': errors.has(`estado${indice}`)}]"        
                        label="sigla"
                        @input="getMunicipios(indice)"
                        :name="`estado${indice}`"
                        >
                        <template v-slot:no-options="{ search, searching }">
                            <template v-if="searching">
                                Nada encontrado com <em>{{ search }}</em>.
                            </template>
                            <em style="opacity: 0.5;" v-else>Começe a digitar algo.</em>
                        </template>
                    </v-select>
                    <span v-show="errors.has(`estado${indice}`)" class="v-select-invalid-feedback">
                        {{ errors.first(`estado${indice}`) }}
                    </span>
                </div>

                 <div class="form-group col-12 col-md-6 col-lg-4">
                    <label>Titulação</label>
                    <v-select
                        class="flex-fill"
                        :options="estados"
                        data-vv-as="estado"
                        :selectOnTab="true"
                        v-model="post.sexo"
                        v-validate="{ required: true }"
                        :disabled="loading"
                        :class="[ {'v-select-invalid': errors.has(`estado${indice}`)}]"        
                        label="sigla"
                        @input="getMunicipios(indice)"
                        :name="`estado${indice}`"
                        >
                        <template v-slot:no-options="{ search, searching }">
                            <template v-if="searching">
                                Nada encontrado com <em>{{ search }}</em>.
                            </template>
                            <em style="opacity: 0.5;" v-else>Começe a digitar algo.</em>
                        </template>
                    </v-select>
                    <span v-show="errors.has(`estado${indice}`)" class="v-select-invalid-feedback">
                        {{ errors.first(`estado${indice}`) }}
                    </span>
                </div>

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
           <div class="row">
                <div class="col-12 d-flex justify-content-between">
                    <label>Endereços</label>
                    <b-button 
                        size="sm" variant="outline-success" 
                        @click="post.enderecos.push({ 
                            cep:null,
                            logradouro: null, 
                            pais_id: null,
                            municipio: null,
                            municipio_id: null,
                            estado: null,
                            user_id: post.id ,
                            deleted: false 
                        })"
                    >
                        <i class="fas fa-plus"></i>
                    </b-button>
                </div>
                <div class="col-12" v-for="(endereco, indice) in post.enderecos" :key="endereco.id">
                      <div class="row">
                        <div class="col-1">
                            <span v-if="!selected && post.enderecos.length > 1" :style="post.enderecos[indice].deleted ? 'opacity: 0.5' : ''"
                                @click="post.enderecos[indice].id
                                        ? post.enderecos[indice].deleted = !post.enderecos[indice].deleted
                                        : post.enderecos.splice(indice, 1)"
                                    class="btn btn-outline-primary btn-sm mb-3"
                                    v-tooltip.bottom="{
                                    content: !post.enderecos[indice].deleted ? 'Deletar' : 'Restaurar',
                                    delay: 0,
                                    class: 'tooltip-custom tooltip-arrow'
                                }"
                                
                            ><i
                                class="fas"
                                :class="{
                                    'fa-trash': !post.enderecos[indice].deleted,
                                    'fa-undo': post.enderecos[indice].deleted
                                }"
                            ></i>
                            </span>

                            <span v-if="selected && selected.enderecos.length > 0" :style="post.enderecos[indice].deleted ? 'opacity: 0.5' : ''"
                                @click="verifyEndereco(indice)"
                                    class="btn btn-outline-primary btn-sm mb-3"
                                    v-tooltip.bottom="{
                                    content: !post.enderecos[indice].deleted ? 'Deletar' : 'Restaurar',
                                    delay: 0,
                                    class: 'tooltip-custom tooltip-arrow'
                                }"
                                
                            ><i
                                class="fas"
                                :class="{
                                    'fa-trash': !post.enderecos[indice].deleted,
                                    'fa-undo': post.enderecos[indice].deleted
                                }"
                            ></i>
                            </span>
                        </div>
                    </div>
                    <div class="row" :style="post.enderecos[indice].deleted ? 'opacity: 0.5' : ''">
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group ">
                                <label for="">CEP</label>
                                <b-form-input
                                    size="sm"
                                    v-validate="{ min: 9,required: true }"
                                    :name="`cep_${indice}`" @change="getCep(indice)" v-mask="'#####-###'"
                                    placeholder="Digite aqui"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`cep_${indice}`)}]"
                                    data-vv-as="CEP"
                                    v-model="post.enderecos[indice].cep"
                                    type="text"
                                    :disabled="loading"
                                ></b-form-input>
                                <span v-show="errors.has(`cep_${indice}`)" class="invalid-feedback d-block">
                                    {{ errors.first(`cep_${indice}`) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group ">
                                <label for="">logradouro</label>
                                <b-form-input
                                    size="sm"
                                    :name="`logradouro_${indice}`"
                                    v-validate="{ required: true }"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`logradouro_${indice}`)}]"
                                    data-vv-as="logradouro"
                                    v-model="post.enderecos[indice].logradouro"
                                    type="text"
                                    :disabled="loading"
                                ></b-form-input>
                                <span v-show="errors.has(`logradouro_${indice}`)" class="invalid-feedback d-block">
                                    {{ errors.first(`logradouro_${indice}`) }}
                                </span>
                            </div>
                        </div>
                    
                      
                    
                        <div class="form-group col-12 col-md-6 col-lg-4">
                            <label>Estado</label>
                            <v-select
                                class="flex-fill"
                                :options="estados"
                                data-vv-as="estado"
                                :selectOnTab="true"
                                v-model="post.enderecos[indice].estado"
                                v-validate="{ required: true }"
                                :disabled="loading"
                                :class="[ {'v-select-invalid': errors.has(`estado${indice}`)}]"        
                                label="sigla"
                                @input="getMunicipios(indice)"
                                :name="`estado${indice}`"
                                >
                                <template v-slot:no-options="{ search, searching }">
                                    <template v-if="searching">
                                        Nada encontrado com <em>{{ search }}</em>.
                                    </template>
                                    <em style="opacity: 0.5;" v-else>Começe a digitar algo.</em>
                                </template>
                            </v-select>
                            <span v-show="errors.has(`estado${indice}`)" class="v-select-invalid-feedback">
                                {{ errors.first(`estado${indice}`) }}
                            </span>
                        </div>

                        <div class="form-group col-12 col-md-6 col-lg-4">
                            <label>Município</label>
                            <v-select
                                class="flex-fill"
                                :name="`municipio${indice}`"
                                :disabled="loading"
                                :options="municipios[indice]"
                                :selectOnTab="false"
                                v-validate="{ required: true }"
                                v-model="post.enderecos[indice].municipio"
                                label="name"
                                data-vv-as="municipio"
                                :class="{'v-select-invalid': errors.has(`municipio${indice}`)}"
                            ></v-select>
                            <span v-show="errors.has(`municipio${indice}`)" class="v-select-invalid-feedback">
                                {{ errors.first(`municipio${indice}`) }}
                            </span>
                        </div>

                        <div class="form-group col-12 col-md-6 col-lg-4">
                            <label>Pais</label>
                            <v-select
                                class="flex-fill"
                                :options="paises"
                                data-vv-as="pais"
                                :selectOnTab="true"
                                v-model="post.enderecos[indice].pais"
                                v-validate="{ required: true }"
                                :disabled="loading"
                                :class="[ {'v-select-invalid': errors.has(`pais${indice}`)}]"        
                                label="sigla"
                                @input="getMunicipios(indice)"
                                :name="`pais${indice}`"
                                >
                                <template v-slot:no-options="{ search, searching }">
                                    <template v-if="searching">
                                        Nada encontrado com <em>{{ search }}</em>.
                                    </template>
                                    <em style="opacity: 0.5;" v-else>Começe a digitar algo.</em>
                                </template>
                            </v-select>
                            <span v-show="errors.has(`pais${indice}`)" class="v-select-invalid-feedback">
                                {{ errors.first(`pais${indice}`) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="todos_tipos_id">Tipo de Acesso:</label><br />
                        <div class="btn-group" style="margin-bottom:-10px;">
                            <div class="switch-field">
                                <template v-for="(userType, index) in usersTypes">
                                    <input
                                        :disabled="loading"
                                        :key="index"
                                        :id="`todos_tipos_${index}`"
                                        name="todos_tipos_id"
                                        type="radio"
                                        :value="userType.id"
                                        v-model="post.todos_tipos_id"
                                    ><label :key="`label_${index}`" :for="`todos_tipos_${index}`">{{ userType.descricao }}</label>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" v-if="post.todos_tipos_id != 1">
                <div class="col-12">
                    <label for="ativo">Acessos Permitidos:</label><br />
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
                usersTypes: [],
                loading: false,
                location: null,
                verify: null,
                post: {
                    id: null,
                    name: null,
                    email: null,
                    todos_tipos_id: 3,
                    tipo_contratacao: null,
                    ativo: 0,
                    acessos: [],
                    enderecos: [{
                        cep: null,
                        logradouro: null, 
                        numero: null,
                        complemento: null,
                        bairro: null,
                        municipio: null,
                        municipio_id: null,
                        estado: null,
                        deleted: false
                    }],
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
                    this.post.id = this.selected.id
                    this.post.name = this.selected.name
                    this.post.email = this.selected.email
                    this.post.todos_tipos_id = this.selected.todos_tipos_id
                    // this.post.departamento_id = this.selected.departamento_id
                    // this.post.empresa = this.selected.empresa
                    // this.post.cnpj_cpf = this.selected.cnpj_cpf
                    // this.post.empresa_id = this.selected.empresa_id
                    this.post.ativo = this.selected.ativo
                    this.post.tipo_contratacao = this.selected.tipo_contratacao
                    this.post.acessos = this.access
                    this.post._method = 'put'

                    this.post.enderecos = [{
                        logradouro: null, 
                        cep: null, 
                        numero: null,
                        bairro: null,
                        complemento: null,
                        municipio: null,
                        municipio_id: null,
                        estado: null,
                        deleted: false
                    }]
                    if(this.selected.enderecos.length > 0) {
                        this.post.enderecos = []
                        this.selected.enderecos.forEach((endereco,indice) => {
                            this.post.enderecos.push({
                                id: endereco.id,
                                cep: endereco.cep, 
                                logradouro: endereco.logradouro, 
                                numero: endereco.numero,
                                complemento: endereco.complemento,
                                bairro: endereco.bairro,
                                municipio: endereco.municipio,
                                estado: endereco.municipio.estado,
                                municipio_id: endereco.municipio_id,
                                latitude: endereco.latitude,
                                longitude: endereco.longitude,
                                user_id: this.post.id,
                                deleted: false
                            })
                            return this.getMunicipios(indice)
                        })
                    }
                } else {
                    this.clear()
                }
            }

        },
        computed: {
            access() {
                return this.selected && this.selected.acessos 
                    ? this.selected.acessos.map(res => res.id) 
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
    
            async save() {
                this.loading = true
                await this.$validator.validateAll().then((valid) => {
                    if(valid) {
                        this.message('Aguarde...', 'Estamos salvando suas informações', 'info', -1);
                        this.post.enderecos.forEach(async (element,indice) => {
                            if(element.logradouro && element.cep) {
                              return await this.getAdress(element,indice)
                            }
                        })

                        setTimeout(() => {

                            axios.post(`${process.env.MIX_BASE_URL}/admin/usuarios${this.url}`, this.post).then( res => {
                                this.clear()
                                if(res.status == 201) {
                                    this.loading = false
                                    this.$emit('store', res.data.response)
                                } else {
                                    this.loading = false
                                    this.$emit('update', res.data.response)
                                }
                                this.message('Sucesso', res.status == 201 ? 'Registro cadastrado.' : 'Registro atualizado.', 'success');
                               
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
                this.post.todos_tipos_id = 3
                this.post.ativo = 0
                this.post.tipo_contratacao = null
                this.post.departamento_id = null
                this.post.cnpj_cpf = null
                this.post.empresa_id = null
                this.post.empresa = null
                this.post.password = null
                this.post.enderecos = [{
                    logradouro: null, 
                    cep: null, 
                    numero: null,
                    complemento: null,
                    bairro: null,
                    municipio: null,
                    municipio_id: null,
                    latitude: null,
                    longitude: null,
                    estado: null,
                    deleted: false
                }]
                
                this.post.acessos = [],
                this.post._method = 'post'
                this.$validator.reset('name')
                this.$validator.reset('email')
            }
        },
        created() {
            axios.get(process.env.MIX_BASE_URL+'/get/tiposusuarios').then(res => {
                this.usersTypes = res.data
            })

            axios.get(process.env.MIX_BASE_URL+'/get/acessos').then(res => {
               
                this.acessos = res.data
            })
          
            this.getEstados()
        },

    }
</script>
