<template>
    <b-modal id="coordenadorModal" size="lg" no-close-on-backdrop>
        <template #modal-header="{ close }">
            <h5 v-if="post.id">Editar Coordenador</h5>
            <h5 v-else>Cadastrar Coordenador</h5>
            <b-button size="sm" variant="outline-danger" @click="close()">x</b-button>
        </template>
        <template>
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
                    <b-form-group label="Tipo" label-class="font-weight-bold">
                        <b-form-select
                            :disabled="loading"
                            name="tipo"
                            v-validate="{ required: true }"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`tipo`)}]"
                            size="sm"
                            data-vv-as="Tipo"
                            class="form-control form-control-sm"
                            v-model="post.tipo"
                        >
                        <option :value="null">Selecione</option>
                        <option v-for="tipo in tipos" :value="tipo.value" :key="tipo.value">
                            {{ tipo.text }}
                        </option>
                        </b-form-select>

                        <span v-show="errors.has(`tipo`)" class="invalid-feedback d-block">
                            {{ errors.first(`tipo`) }}
                        </span>
                    </b-form-group>
                </b-col>

                <b-col cols="12" sm="6" lg="6">
                    <b-form-group label="Ano" label-class="font-weight-bold">
                        <b-form-input
                            name="ano"
                            size="sm"
                            v-model="post.ano"
                            type="text"
                            :disabled="loading"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`ano`)}]"
                            v-validate="{ required: true }"
                            aria-describedby="input-1-live-feedback"
                            data-vv-as="ano"
                        ></b-form-input>
                        <span v-show="errors.has(`ano`)" class="invalid-feedback">
                            {{ errors.first(`ano`) }}
                        </span>
                    </b-form-group>
                </b-col>

                <b-col cols="12" sm="6" lg="4">
                    <b-form-group
                        label="Coordenador Geral"
                        label-class="font-weight-bold"
                        >
                        <b-form-radio-group
                            :disabled="loading"
                            v-model="post.geral"
                            :options="options"
                            :button-variant="`outline-primary`" 
                            size="sm"
                            v-validate="{ required: post.geral == 0 ? true : false }"
                            name="geral"
                            buttons
                        ></b-form-radio-group>
                        <span v-show="errors.has(`geral`)" class="invalid-feedback d-block">
                            {{ errors.first(`geral`) }}
                        </span>
                    </b-form-group>
                </b-col>


                <b-col cols="12" sm="12" lg="12" v-if="post.tipo == 3">
                    <b-form-group label="DIVISÕES TEMÁTICAS:" label-class="font-weight-bold">
                        <b-form-select
                            :disabled="loading"
                            name="divisoes_tematicas"
                            v-validate="{ required: post.tipo == 3 ? true : false }"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`divisoes_tematicas`)}]"
                            size="sm"
                            data-vv-as="DIVISÕES TEMÁTICAS"
                            v-model="post.dt"
                        >
                        <option :value="null">Selecione</option>
                        <option v-for="divisoes_tematica in divisoes_tematicas" :value="divisoes_tematica.id" :key="divisoes_tematica.id">
                            {{ divisoes_tematica.descricao }}
                        </option>
                        </b-form-select>

                        <span v-show="errors.has(`divisoes_tematicas`)" class="invalid-feedback d-block">
                            {{ errors.first(`divisoes_tematicas`) }}
                        </span>
                    </b-form-group>
                </b-col>

                <b-col cols="12" sm="12" lg="12" v-if="post.tipo == 2">
                    <b-form-group label="INTERCOM JÚNIOR:" label-class="font-weight-bold">
                        <b-form-select
                            :disabled="loading"
                            name="divisoes_tematicas_jr"
                            v-validate="{ required: post.tipo == 2 ? true : false }"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`divisoes_tematicas_jr`)}]"
                            size="sm"
                            data-vv-as="DIVISÕES TEMÁTICAS"
                            v-model="post.ij"
                        >
                        <option :value="null">Selecione</option>
                        <option v-for="divisoes_tematica_jr in divisoes_tematicas_jr" :value="divisoes_tematica_jr.id" :key="divisoes_tematica_jr.id">
                            {{ divisoes_tematica_jr.descricao }}
                        </option>
                        </b-form-select>

                        <span v-show="errors.has(`divisoes_tematicas_jr`)" class="invalid-feedback d-block">
                            {{ errors.first(`divisoes_tematicas_jr`) }}
                        </span>
                    </b-form-group>
                </b-col>

                <b-col cols="12" sm="12" lg="12" v-if="post.tipo == 1">
                    <b-form-group label="GPs:" label-class="font-weight-bold">
                        <b-form-select
                            :disabled="loading"
                            name="gps"
                            v-validate="{ required: post.tipo == 2 ? true : false }"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`gps`)}]"
                            size="sm"
                            data-vv-as="DIVISÕES TEMÁTICAS"
                            v-model="post.gps"
                        >
                        <option :value="null">Selecione</option>
                        <option v-for="gp in gps" :value="gp.id" :key="gp.id">
                            {{ gp.descricao }}
                        </option>
                        </b-form-select>

                        <span v-show="errors.has(`gps`)" class="invalid-feedback d-block">
                            {{ errors.first(`gps`) }}
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
        props: ['selected', 'id'],
        mixins: [
            MixinsGlobal
        ],
        data() {
            return {
                baseUrl: process.env.MIX_BASE_URL,
                loading: false,
                verify: null,
                gps: [],
                divisoes_tematicas_jr: [],
                divisoes_tematicas: [],
                tipo_expocom: false,
                post: {
                    id: null,
                    user_id: null,
                    name: null,
                    tipo: null,
                    gps: null,
                    ij: null,
                    dt: null,
                    ano: null,
                    geral: null,
                    _method: 'post'
                },
                options: [
                    { text: 'Não', value: 0 },
                    { text: 'Sim', value: 1 }
                ],
                tipos: [
                    { text: 'GPs', value: 1 },
                    { text: 'Intercom Junior', value: 2 },
                    { text: 'Expocom', value: 3 },
                    { text: 'Publicom', value: 4 },
                ],
            }
        },
        watch: {
            selected() {
                if(this.selected) {
                    this.$forceUpdate()
                    this.post.user_id = this.selected.id
                    this.post.id = this.selected && this.selected.coordenador_nacional && this.selected.coordenador_nacional ? this.selected.coordenador_nacional.id : null
                    this.post.name = this.selected.name ? this.selected.name : null
                    this.post.tipo = this.selected && this.selected.coordenador_nacional && this.selected.coordenador_nacional ? this.selected.coordenador_nacional.tipo : null
                    this.post.dt = this.selected && this.selected.coordenador_nacional ? this.selected.coordenador_nacional.dt : null
                    this.post.gps = this.selected && this.selected.coordenador_nacional ? this.selected.coordenador_nacional.gps : null
                    this.post.ij = this.selected && this.selected.coordenador_nacional ? this.selected.coordenador_nacional.ij : null
                    this.post.ano = this.selected && this.selected.coordenador_nacional ? this.selected.coordenador_nacional.ano : null
                    this.post.geral = this.selected && this.selected.coordenador_nacional ? this.selected.coordenador_nacional.geral : null
                    this.post._method = this.post && this.post.id ? 'put' : 'post'

                } else {
                    this.clear()
                }
            },
            post: {
                handler:function(newVal) {
                    this.tipo_expocom = newVal.tipo == 'Expocom' ? true : false 
                    // this.tipo_ij = newVal.tipo == 'Intercom Junior' ? true : false 
                    if(this.tipo_expocom == true){
                        this.$validator.pause('regiao')
                    }                
                },
                deep:true
            }
        },
        computed: {
            url() {
                return this.post && this.post.id ? `/${this.post.id}` : ''
            },

        },
        methods: {    
            async save() {
                this.loading = true

                if(this.post.dt == null && this.post.tipo == 3){
                    this.message('Erro', 'Selecione uma divisão temática apenas!', 'error');
                    this.loading = false
                    return

                }else{

                    await this.$validator.validateAll().then((valid) => {
                        if(valid) {
                            this.message('Aguarde...', 'Estamos salvando suas informações', 'info', -1);

                            setTimeout(() => {
                                axios.post(`${process.env.MIX_BASE_URL}/admin/coordenador_nacional${this.url}`, this.post).then( res => {
                                    
                                    this.clear()
                                    if(res.success == "success") {
                                        window.location.reload()
                                        this.loading = false
                                        this.$emit('store', res.data.response)
                                    } else {
                                        window.location.reload()
                                        this.loading = false
                                        this.$emit('update', res.data.response)
                                    }
                                    this.message('Sucesso', res.success == "success" ? 'Usuário cadastrado.' : 'Usuário atualizado.', 'success');
                                
                                }).catch(error => {
                                    if(error.response.status == 422) {
                                        this.loading = false
                                        return this.message('Campos Obrigatórios', 'Preencha todos os campos obrigatórios', 'error');
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
                }
            },
            clear() {
                this.post.id = null
                this.post.name = null
                this.post._method = 'post'
                this.$validator.reset('name')
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
            getDivisoesTematicasJr(){
                let urlgetDivisoesTematicasJr = this.baseUrl+"/get/divisoes-tematicas-jr";

                $.ajax({
                    method: "GET",
                    url: urlgetDivisoesTematicasJr,
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
            getGp(){
                let urlgetgp = this.baseUrl+"/get/gp";

                $.ajax({
                    method: "GET",
                    url: urlgetgp,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.gps = res
                    },
                    error: (res) => {
                        console.log(res)
                        
                    }
                }); 
            },

        },
        created() {
            this.getDivisoesTematicas(),
            this.getDivisoesTematicasJr(),
            this.getGp()
        }
    }
</script>

<style scoped>
    ::v-deep .modal-backdrop {
        opacity: 0.5 !important;
    }
</style>