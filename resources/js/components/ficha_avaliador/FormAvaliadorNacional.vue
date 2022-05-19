<template>

<div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <h1>FICHA DE AVALIADOR NACIONAL - {{ this.tipo_name }}</h1>
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
                    </b-row> 
                </div>
            </div>


            <div class="card mt-3" v-if="tipo == 1">
                <div class="card-header text-center">
                    <h2>{{ this.post && this.post.tipo ? this.post.tipo.name : ''}} </h2>
                </div>

                <div class="card-body">
                    <b-row class="align-items-center">
                        <div class="col-12 col-sm-12 col-lg-12 text-center">
                            <label for="ativo" label-class="font-weight-bold" style="font-size:20px !important; color:black;">CLIQUE NOS BOTÕES E ESCOLHA UM GRUPO DE PESQUISA:</label><br />
                            <label for="ativo" label-class="font-weight-bold" style="color:red;">*Selecione apenas um Grupo de Pesquisa</label><br />

                            <div class="">
                                <v-select
                                    class="flex-fill"
                                    :options="gps"
                                    :reduce="gp => gp.id"
                                    data-vv-as="Grupo de Pesquisa"
                                    :selectOnTab="true"
                                    v-model="post.gps"
                                    multiple
                                    v-validate="{ required: true }"
                                    :disabled="loading"
                                    :class="[{ 'v-select-invalid': errors.has(`gps`) }]"
                                    label="descricao"
                                    :name="`gps`"
                                    placeholder="Selecione um grupo de pesquisa"
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
                            </div>
                        </div>
                    </b-row>    
                    <span v-show="errors.has(`gps`)" class="invalid-feedback d-block m-0">
                        {{ errors.first(`gps`) }}
                    </span>

                </div>
            </div>

            <div class="card mt-3" v-if="tipo == 2">
                <div class="card-header text-center">
                    <h2>INTERCOM JÚNIOR (IJ)</h2>
                </div>

                <div class="card-body">
                    <b-row>
                        <div class="col-12  text-center m-1">
                            <label for="ativo" label-class="font-weight-bold" style="font-size:20px !important; color:black;">CLIQUE NOS BOTÕES E ESCOLHA DIVISÕES TEMÁTICAS:</label><br />
                            <label for="ativo" label-class="font-weight-bold" style="color:red;">*Selecione apenas uma divisão temática</label><br />

                            <div class="switch-field-one">
                                <span v-for="(divisoes_tematica, index) in divisoes_tematicas_jr" :key="index" class="text-center">
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
                                        v-validate="{ required: true }"
                                    ><label :key="`label_${index}`" :for="`dv_${index}`" class="mr-2">{{ divisoes_tematica.dt }} - {{ divisoes_tematica.descricao }}</label>
                                </span>
                            </div>
                            <span v-show="errors.has(`divisoes_tematicas`)" class="invalid-feedback d-block m-0">
                                {{ errors.first(`divisoes_tematicas`) }}
                            </span>
                        </div>
                    </b-row>    
                </div>
            </div>

            <div class="card mt-3" v-if="tipo == 3">
                <div class="card-header text-center">
                    <h2>Publicom</h2>
                </div>

                <div class="card-body">
                    <b-row>
                        <div class="col-12 m-1  text-center">
                            <label for="ativo" label-class="font-weight-bold" style="font-size:20px !important; color:black;">CLIQUE NOS BOTÕES E ESCOLHA DIVISÕES TEMÁTICAS:</label><br />
                            <label for="ativo" label-class="font-weight-bold" style="color:red;">*Selecione apenas uma divisão temática</label><br />

                            <div class="switch-field-one">
                                <span v-for="(divisoes_tematica, index) in divisoes_tematicas" :key="index" class="text-center">
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
                                        v-validate="{ required: true }"
                                    ><label :key="`label_${index}`" :for="`dv_${index}`" class="mr-2">{{ divisoes_tematica.dt }} - {{ divisoes_tematica.descricao }}</label>
                                </span>
                            </div>
                            <span v-show="errors.has(`divisoes_tematicas`)" class="invalid-feedback d-block m-0">
                                {{ errors.first(`divisoes_tematicas`) }}
                            </span>
                        </div>

                    </b-row>    
                </div>
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
        <notifications group="submit" position="bottom center" width="600px" />

</div>

</template>

<script>
    import MixinsGlobal from  '../mixins/global-mixins'

      export default {
        props: ['user', 'tipo'],
        mixins: [ MixinsGlobal],
        data() {
            return {
                loading: false,
                baseUrl: process.env.MIX_BASE_URL,
                tipo_name: this.tipo == 1 ? 'GP' : this.tipo == 2 ? "IJ" : "Publicom",
                divisoes_tematicas: [],
                divisoes_tematicas_jr: [],
                gps: [],
                loading: false,
                post: {
                    id: this.user && this.user.id ? this.user.id : null,
                    name: this.user && this.user.name ? this.user.name : null,
                    email: this.user && this.user.email ? this.user.email : null,
                    cpf: this.user && this.user.cpf ? this.user.cpf : null,
                    tipo: this.tipo ? this.tipo : null,
                    divisoes_tematicas: [],
                    divisoes_tematicas_jr: [],
                    gps: [],
                    _method: 'post'
                },
            }
        },
        watch: {
            user(){
                if(this.user){
                    this.$forceUpdate()
                    this.post.id = this.user && this.user.id ? this.user.id : null
                    this.post.name = this.user && this.user.name ? this.user.name : null
                    this.post.email = this.user && this.user.email ? this.user.email : null 
                    this.post.cpf = this.user && this.user.cpf ? this.user.cpf : null
                    this.post.divisoes_tematicas = this.find_divisoes_tematicas,
                    this.post.divisoes_tematicas_jr = this.find_divisoes_tematicas_jr,
                    this.post.gps = this.find_gps                    
                }
            },
        },
        computed: {
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
            find_gps(){
                return this.user && this.user.todos_gps
                    ? this.user.todos_gps.map(res => res.id)
                    : []
            }
        },
        methods: {  
            getDivisoesTematicas(){
                $.ajax({
                    method: "GET",
                    url: "get/divisoes-tematicas",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.divisoes_tematicas = res
                        this.post.divisoes_tematicas = this.find_divisoes_tematicas
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
                        this.post.divisoes_tematicas_jr = this.find_divisoes_tematicas_jr
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
                                url: "avaliador/nacional/save",
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
            getGp(){
                let urlgetgp = this.baseUrl+"/get/gp";

                $.ajax({
                    method: "GET",
                    url: urlgetgp,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.gps = res
                        this.post.gps = this.find_gps
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
