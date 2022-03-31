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

                <b-col cols="12" sm="6" lg="6" v-if="!tipo_expocom">
                    <b-form-group label="Regiao" label-class="font-weight-bold" >
                        <b-form-select
                            :disabled="loading"
                            name="regiao"
                            v-validate="{ required: true }"
                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`regiao`)}]"
                            size="sm"
                            data-vv-as="Regiao"
                            class="form-control form-control-sm"
                            v-model="post.regiao"
                        >
                        <option :value="null">Selecione</option>
                        <option v-for="regiao in regioes" :value="regiao.value" :key="regiao.value">
                            {{ regiao.text }}
                        </option>
                        </b-form-select>

                        <span v-show="errors.has(`regiao`)" class="invalid-feedback d-block">
                            {{ errors.first(`regiao`) }}
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

                <b-col cols="12" sm="12" lg="12" v-if="tipo_expocom">
                    <label for="ativo" label-class="font-weight-bold" style="font-size:20px !important; color:black;">DIVISÕES TEMÁTICAS:</label><br />
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
                                v-model="post.dt"
                            ><label :key="`label_${index}`" :for="`dv_${index}`" class="mr-2">{{ divisoes_tematica.dt }} - {{ divisoes_tematica.descricao }}</label>
                        </span>
                    </div>
                </b-col>

                <!-- <b-col cols="12" sm="12" lg="12" v-if="tipo_ij">
                    <label for="ativo" label-class="font-weight-bold" style="font-size:20px !important; color:black;">INTERCOM JUNIOR:</label><br />
                    <div class="switch-field-one">
                        <span v-for="(divisoes_tematica_jr, indexJunior) in divisoes_tematicas_jr" :key="indexJunior">
                            <input
                                :disabled="loading"
                                :id="`dv_${indexJunior}`"
                                name="divisoes_tematicas"
                                type="checkbox"
                                :class="[ 'form-control radio-inline radio_lista radio',{ 'is-invalid': errors.has(`divisoes_tematicas_jr`) }]"                                        
                                aria-describedby="input-1-live-feedback"
                                data-vv-as="DIVISÃO TEMÁTICA"
                                :value="divisoes_tematica_jr.id"
                                v-model="post.dt"
                            ><label :key="`label_${indexJunior}`" :for="`dv_${indexJunior}`" class="mr-2">{{ divisoes_tematica_jr.dt }} - {{ divisoes_tematica_jr.descricao }}</label>
                        </span>
                    </div>
                </b-col> -->


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
                divisoes_tematicas: [],
                tipo_expocom: false,
                // tipo_ij: false,
                post: {
                    id: null,
                    user_id: null,
                    name: null,
                    dt: [],
                    ano: null,
                    tipo: null,
                    _method: 'post'
                },
                options: [
                    { text: 'Não', value: 0 },
                    { text: 'Sim', value: 1 }
                ],
                tipos: [
                    { text: 'Expocom', value: "Expocom" },
                    { text: 'Divisões Tematicas', value: "Divisões Tematicas" },
                    { text: 'Intercom Junior', value: "Intercom Junior" },
                    { text: 'Mesa', value: "Mesa" }
                ],
                regioes: [
                    { text: 'Norte', value: "Norte" },
                    { text: 'Nordeste', value: "Nordeste" },
                    { text: 'Sul', value: 'Sul' },
                    { text: 'Sudeste', value: "Sudeste" },
                    { text: 'Centro Oeste', value: "Centro Oeste" }
                ],
            }
        },
        watch: {
            selected() {
                if(this.selected) {
                    this.$forceUpdate()
                    this.post.user_id = this.selected.id
                    this.post.id = this.selected && this.selected.coordenador_regional && this.selected.coordenador_regional ? this.selected.coordenador_regional.id : null
                    this.post.name = this.selected.name ? this.selected.name : null
                    this.post.tipo = this.selected && this.selected.coordenador_regional && this.selected.coordenador_regional ? this.selected.coordenador_regional.tipo : null
                    this.post.regiao = this.selected && this.selected.coordenador_regional && this.selected.coordenador_regional ? this.selected.coordenador_regional.regiao : null
                    this.post.dt = this.selected && this.selected.coordenador_regional && this.selected.coordenador_regional ? [this.selected.coordenador_regional.dt] : []
                    this.post.ano = this.selected && this.selected.coordenador_regional && this.selected.coordenador_regional ? this.selected.coordenador_regional.ano : null
                    this.post._method = this.post && this.post.id ? 'put' : 'post'

                } else {
                    this.clear()
                }
            },
            post: {
                handler:function(newVal) {
                    console.log(newVal)
                    this.tipo_expocom = newVal.tipo == 'Expocom' ? true : false 
                    // this.tipo_ij = newVal.tipo == 'Intercom Junior' ? true : false 

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

                if(this.post.dt.length > 1){
                    this.message('Erro', 'Selecione uma divisão temática apenas!', 'error');
                    this.loading = false
                    return

                }else{

                    await this.$validator.validateAll().then((valid) => {
                        if(valid) {
                            this.message('Aguarde...', 'Estamos salvando suas informações', 'info', -1);

                            setTimeout(() => {
                                axios.post(`${process.env.MIX_BASE_URL}/admin/coordenador${this.url}`, this.post).then( res => {
                                    
                                    this.clear()
                                    if(res.status == 201) {
                                        this.loading = false
                                        this.$emit('store', res.data.response)
                                    } else {
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
                }
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
            clear() {
                this.post.id = null
                this.post.name = null
                this.post._method = 'post'
                this.$validator.reset('name')
            }
        },
        created() {
            this.getDivisoesTematicas()

        },

    }
</script>

<style scoped>
    ::v-deep .modal-backdrop {
        opacity: 0.5 !important;
    }
</style>