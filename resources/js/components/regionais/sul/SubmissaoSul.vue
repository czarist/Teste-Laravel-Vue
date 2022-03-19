<template>

<div>
    <div class="row justify-content-center" v-on="this.tipos()">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <h1>SUBMISSÃO DE TRABALHO</h1>
                    <h2>{{ this.post && this.post.tipo ? this.post.tipo.name : ''}} </h2>
                    <h2>Região - {{ this.tipo && this.post.tipo ? this.post.tipo.regiao: "" }}</h2>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header text-center">
                    <h2>DIVISÃO TEMÁTICA (DT)</h2>
                </div>

                <div class="card-body">
                    <b-row>
                        <div class="col-12  text-center">
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
                        </div>

                    </b-row>    
                    <span v-show="errors.has(`divisoes_tematicas`)" class="invalid-feedback d-block m-0">
                        {{ errors.first(`divisoes_tematicas`) }}
                    </span>

                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header text-center">
                </div>

                <div class="card-body">
                    <b-row>
                        <b-col cols="12" sm="6" lg="12" class="text-center">
                            <b-form-group label="TÍTULO" style="font-size:20px !important; color:black;">
                                    <textarea 
                                        class="form-control" 
                                        v-on:keyup="liveCountDown" 
                                        v-model="post.titulo" 
                                        name="titulo"
                                        :class="['form-control form-control-sm', {'is-invalid': errors.has(`titulo`)}]"
                                        v-validate="{ required: true }"
                                        ></textarea>

                                        <p>Total restante letras restante: <span v-bind:class="{'text-danger': generateErr }">{{totalRemainCount}}</span></p>

                                <span v-show="errors.has(`titulo`)" class="invalid-feedback">
                                    {{ errors.first(`titulo`) }}
                                </span>
                            </b-form-group>
                        </b-col>


                        <b-col cols="12" sm="12" lg="12" class="text-center">
                            <label label-class="font-weight-bold" style="font-size:20px !important; color:black;">PALAVRAS-CHAVE</label><br />
                            <b-row>
                                <b-col cols="12" sm="6" lg="6">
                                    <b-form-group label="1." label-class="font-weight-bold">
                                        <b-form-input
                                            name="palavra_chave_1"
                                            size="sm"
                                            v-model="post.palavra_chave_1"
                                            type="text"
                                            :disabled="loading"
                                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`palavra_chave_1`)}]"
                                            aria-describedby="input-1-live-feedback"
                                            data-vv-as="Palavra Chave 1"
                                            v-validate="{ required: true }"
                                        ></b-form-input>
                                        <span v-show="errors.has(`palavra_chave_1`)" class="invalid-feedback">
                                            {{ errors.first(`palavra_chave_1`) }}
                                        </span>
                                    </b-form-group>
                                </b-col>

                                <b-col cols="12" sm="6" lg="6">
                                    <b-form-group label="2." label-class="font-weight-bold">
                                        <b-form-input
                                            name="palavra_chave_2"
                                            size="sm"
                                            v-model="post.palavra_chave_2"
                                            type="text"
                                            :disabled="loading"
                                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`palavra_chave_2`)}]"
                                            aria-describedby="input-2-live-feedback"
                                            data-vv-as="Palavra Chave 2"
                                            v-validate="{ required: true }"
                                        ></b-form-input>
                                        <span v-show="errors.has(`palavra_chave_2`)" class="invalid-feedback">
                                            {{ errors.first(`palavra_chave_2`) }}
                                        </span>
                                    </b-form-group>
                                </b-col>

                                <b-col cols="12" sm="6" lg="6">
                                    <b-form-group label="3." label-class="font-weight-bold">
                                        <b-form-input
                                            name="palavra_chave_3"
                                            size="sm"
                                            v-model="post.palavra_chave_3"
                                            type="text"
                                            :disabled="loading"
                                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`palavra_chave_3`)}]"
                                            aria-describedby="input-3-live-feedback"
                                            data-vv-as="Palavra Chave 3"
                                            v-validate="{ required: true }"
                                        ></b-form-input>
                                        <span v-show="errors.has(`palavra_chave_3`)" class="invalid-feedback">
                                            {{ errors.first(`palavra_chave_3`) }}
                                        </span>
                                    </b-form-group>
                                </b-col>

                                <b-col cols="12" sm="6" lg="6">
                                    <b-form-group label="4." label-class="font-weight-bold">
                                        <b-form-input
                                            name="palavra_chave_4"
                                            size="sm"
                                            v-model="post.palavra_chave_4"
                                            type="text"
                                            :disabled="loading"
                                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`palavra_chave_4`)}]"
                                            aria-describedby="input-4-live-feedback"
                                            data-vv-as="Palavra Chave 4"
                                        ></b-form-input>
                                        <span v-show="errors.has(`palavra_chave_4`)" class="invalid-feedback">
                                            {{ errors.first(`palavra_chave_4`) }}
                                        </span>
                                    </b-form-group>
                                </b-col>

                                <b-col cols="12" sm="6" lg="6">
                                    <b-form-group label="5." label-class="font-weight-bold">
                                        <b-form-input
                                            name="palavra_chave_5"
                                            size="sm"
                                            v-model="post.palavra_chave_5"
                                            type="text"
                                            :disabled="loading"
                                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`palavra_chave_5`)}]"
                                            aria-describedby="input-5-live-feedback"
                                            data-vv-as="Palavra Chave 5"
                                        ></b-form-input>
                                        <span v-show="errors.has(`palavra_chave_5`)" class="invalid-feedback">
                                            {{ errors.first(`palavra_chave_5`) }}
                                        </span>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                        </b-col>

                    </b-row>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header py-1 d-flex justify-content-between align-items-center">
                    <h2 >Coautor(es) e Orientador(es)</h2>
                    <button :disabled="loading"  class="btn btn-sm btn-primary" title="Adicionar Endereço" @click="addCoaOri()">
                        <i class="fas fa-plus"></i> Adicionar
                    </button>

                </div>

                <div class="card-body">
                    <b-row>
                        <b-col cols="12" sm="12" lg="12" class="text-center" v-for="(coautorOrientador, indiceCoautorOrientador) in post.coautoresOrientadores" :key="indiceCoautorOrientador">
                            <b-col cols="12" class="d-block w-100 bg-light p-3 mb-3">
                                <b-row>
                                    <b-col cols="12" class="text-right d-flex justify-content-between align-items-center">
                                        <button 
                                            :disabled="loading" 
                                            v-b-modal.modal-deletar-coautores-orientadores
                                            class="btn btn-sm btn-secondary" 
                                            title="Deletar Coautor(es) e Orientador(es)" 
                                            @click="deleteSelectCoautoresOrientadores = { indice: indiceCoautorOrientador };"
                                        >
                                            <i class="fas fa-trash">DELETAR</i>
                                        </button>
                                    </b-col>

                                    <b-col cols="12" sm="6" lg="6" class="text-center mb-3">
                                        <b-form-group label="Nome completo (eventuais erros sairão no certificado)" label-class="font-weight-bold">
                                            <b-form-input
                                                :name="`nome_completo${indiceCoautorOrientador}`"
                                                size="sm"
                                                v-model="post.coautoresOrientadores[indiceCoautorOrientador].nome_completo"
                                                type="text"
                                                :disabled="loading"
                                                :class="['form-control form-control-sm', {'is-invalid': errors.has(`nome_completo${indiceCoautorOrientador}`)}]"
                                                aria-describedby="input-1-live-feedback"
                                                data-vv-as="Nome completo"
                                                v-validate="{ required: true }"
                                            ></b-form-input>
                                            <span v-show="errors.has(`nome_completo${indiceCoautorOrientador}`)" class="invalid-feedback">
                                                {{ errors.first(`nome_completo${indiceCoautorOrientador}`) }}
                                            </span>
                                        </b-form-group>
                                    </b-col>

                                    <b-col cols="12" sm="3" lg="3" class="text-center mb-3">
                                        <b-form-group label="CPF" label-class="font-weight-bold">
                                            <b-form-input
                                                :name="`cpf${indiceCoautorOrientador}`"
                                                size="sm"
                                                :disabled="loading"
                                                v-model="post.coautoresOrientadores[indiceCoautorOrientador].cpf"
                                                type="text"
                                                v-mask="'###.###.###-##'"
                                                :class="['form-control form-control-sm', {'is-invalid': errors.has(`cpf${indiceCoautorOrientador}`)}]"
                                                aria-describedby="input-1-live-feedback"
                                                data-vv-as="CPF"
                                                v-validate="{ required: true, verificaCPF: post.coautoresOrientadores[indiceCoautorOrientador].cpf  }"
                                            ></b-form-input>
                                            <span v-show="errors.has(`cpf${indiceCoautorOrientador}`)" class="invalid-feedback">
                                                {{ errors.first(`cpf${indiceCoautorOrientador}`) }}
                                            </span>
                                        </b-form-group>
                                    </b-col>

                                    <b-col cols="12" sm="3" lg="3" class="text-center mb-3">
                                        <b-form-group label="Categoria" label-class="font-weight-bold">
                                            <b-form-select
                                                :disabled="loading"
                                                :name="`categoria${indiceCoautorOrientador}`"
                                                v-validate="{ required: true }"
                                                :class="['form-control form-control-sm', {'is-invalid': errors.has(`categoria${indiceCoautorOrientador}`)}]"
                                                size="sm"
                                                data-vv-as="Categoria"
                                                class="form-control form-control-sm"
                                                v-model="post.coautoresOrientadores[indiceCoautorOrientador].categoria"
                                            >
                                                <option :value="null">Selecione a Titulação</option>
                                                <option value="1">Coautor(a)</option>
                                                <option value="2">Orientador(a)</option>
                                            </b-form-select>

                                            <span v-show="errors.has(`categoria${indiceCoautorOrientador}`)" class="invalid-feedback">
                                                {{ errors.first(`categoria${indiceCoautorOrientador}`) }}
                                            </span>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                            </b-col>
                        </b-col>

                        <b-col cols="12" sm="12" lg="12" class="text-center">
                            <b-row>
                                <b-col cols="6" sm="6" lg="6">
                                    <b-form-checkbox
                                        id="termo_autoria"
                                        v-model="post.termo_autoria"
                                        name="termo_autoria"
                                        :value="post.termo_autoria"
                                        v-validate="{ required: true }"
                                        data-vv-as="TERMO DE AUTORIA"
                                        class="m-3"
                                        >
                                        TERMO DE AUTORIA
                                    </b-form-checkbox>

                                    <b-button v-b-modal.modal-termo-autoria>Ver Termo de autoria</b-button>
                                    <span v-show="errors.has(`termo_autoria`)" class="invalid-feedback d-block m-0">
                                        {{ errors.first(`termo_autoria`) }}
                                    </span>

                                </b-col>

                                <b-col cols="6" sm="6" lg="6">
                                    <b-form-checkbox
                                        id="autorizacao"
                                        v-model="post.autorizacao"
                                        name="autorizacao"
                                        :value="post.autorizacao"
                                        v-validate="{ required: true }"
                                        data-vv-as="AUTORIZAÇÃO"
                                        class="m-3"
                                        >
                                        AUTORIZAÇÃO
                                    </b-form-checkbox>

                                    <b-button v-b-modal.modal-autorizacao>Ver Autorização</b-button>
                                <span v-show="errors.has(`autorizacao`)" class="invalid-feedback d-block m-0">
                                    {{ errors.first(`autorizacao`) }}
                                </span>

                                </b-col>

                            </b-row>
                        </b-col>
                    </b-row>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header text-center">
                    <h2>Enviar o arquivo:</h2>
                </div>

                <div class="card-body">
                    <div class="alert alert-warning" v-if="size_arquivos > total_size">
                        <i class="fas fa-exclamation"></i> Os <b>arquivo enviado</b> ultrapassa o limite de <b>2MB</b>. Para enviar a documentação selecione arquivos menores. <br>
                        Envio somente de PDF
                    </div>

                    <b-col cols="12" sm="12" lg="12" class="m-3">
                        <b-form-invalid-feedback v-if="estaCiente == false" class="text-center">Declare que esta ciente</b-form-invalid-feedback>

                        <b-form-checkbox
                            id="ciente"
                            v-model="ciente"
                            name="ciente"
                            :value="true"
                            :unchecked-value="false"
                            :estaCiente="estaCiente"                            
                            data-vv-as="Declaro estar ciente"
                            class="m-3"
                            >
                            Declaro estar ciente de que o link deverá estar acessível durante o período do Expocom, até a etapa nacional.
                        </b-form-checkbox>
                    </b-col>

                    <b-col cols="12" sm="12" lg="12" class="m-3">
                        <label class="font-weight-bold">Envio de arquivo:</label>
                        <input 
                            @change="addFile($event)"
                            :name="`file`"
                            data-vv-as="Arquivo"
                            type="file"
                            :class="['form-control form-control-sm d-block w-100', {'is-invalid': errors.has(`file`)}]"
                            v-validate="{ required: true, ext:['pdf'] }"
                        >

                        <span v-show="errors.has(`file`)" class="invalid-feedback d-block m-0">
                            {{ errors.first(`file`) }}
                        </span>
                    </b-col>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-8">
                            <b-alert 
                                show variant="danger"
                                v-if="post && post.file == null"
                            >
                                Preencha todos os campos e envie o arquivo para poder salvar
                            </b-alert>

                            <b-alert 
                                show variant="danger"
                                v-if="size_arquivos > total_size"
                            >
                                PDF com mais de 2 mega, favor inserir um pdf com tamanho menor
                            </b-alert>

                        </div>
                        <div class="col d-flex justify-content-end">
                            <b-button :disabled=" loading" size="md" variant="outline-danger" class="align-self-end m-1" @click="back()">
                                Voltar
                            </b-button>

                            <b-button
                                :disabled="loading || size_arquivos > total_size"
                                size="md" 
                                variant="outline-success" 
                                class="align-self-end m-1" @click="save()">
                                Salvar
                            </b-button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
     <b-modal id="modal-termo-autoria">
        Declaro que responsabilizo-me pela originalidade e autoria do trabalho submetido à apreciação para esse congresso, atestando que todos os trechos que tenham sido transcritos de outros documentos (publicados ou não) e que não sejam de minha exclusiva autoria estão citados entre aspas e está identificada a fonte e a página de que foram extraídas (se transcrito literalmente) ou somente indicadas fonte e ano (se utilizada a ideia do autor citado), conforme normas e padrões ABNT vigentes.

        Declaro, ainda, estar ciente que a infração destas normas incorrerá nas responsabilidades civis e criminais da legislação vigente – Lei n. 9610/98 – de Direitos Autorias, que neste caso serão por mim assumidas integralmente.
     </b-modal>

    <b-modal id="modal-autorizacao">
        Autorizo a INTERCOM – Sociedade Brasileira de Estudos Interdisciplinares da Comunicação a publicar no seu site ou nas demais publicações científicas sob sua tutela o texto de minha autoria, da qual dispenso qualquer tipo de remuneração ou contraprestação econômica pela divulgação.

        Declaro, para os devidos fins, sob a responsabilidade civil e criminal da legislação atual vigente, que eu sou o autor do artigo. Declaro, ainda, que o artigo é INÉDITO no Brasil e sua publicação não encontra-se pendente em outro local, considerando-se licenciado com EXCLUSIVIDADE para a INTERCOM, por prazo indeterminado a contar da finalização da submissão do texto.
    </b-modal>

    <b-modal id="modal-deletar-coautores-orientadores">
        <div class="modal-body">
            <div class="alert alert-danger">
                <p>
                    ATENÇÃO: <br />
                    Todos os dados serão perdidos, deseja mesmo deletar ?
                </p>
                
                <p class="text-center">
                    <button :disabled="loading" type="button" class="btn btn-sm btn-primary" @click="removeCoaOri(deleteSelectCoautoresOrientadores.indice)">
                        SIM
                    </button>

                    <button :disabled="loading" type="button" class="btn btn-sm btn-secondary" @click="$bvModal.hide('modal-deletar-coautores-orientadores'); " >
                        NÃO
                    </button>
                </p>
            </div>
        </div>
    </b-modal>

    <notifications group="submit" position="center bottom" width="700px" />
</div>

</template>

<script>
    import debounce from 'debounce'
    import moment from 'moment'
    import MixinsGlobal from  '../../mixins/global-mixins'

      export default {
        props: ['user' , 'regiao', 'tipo' ],
        mixins: [ MixinsGlobal],
        data() {
            return {
                loading: false,
                baseUrl: process.env.MIX_BASE_URL,
                divisoes_tematicas: [],
                titulacoes: [],
                loading: false,
                ciente: false,
                verify: null,
                limitmaxCount: 200,
                totalRemainCount: 200,
                total_size: 2097152,
                size_arquivos: 0,
                generateErr: false,
                deleteSelectCoautoresOrientadores: { indice: null},
                post: {
                    id: null,
                    titulo: null,
                    palavra_chave_1: null,
                    palavra_chave_2: null,
                    palavra_chave_3: null,
                    palavra_chave_4: null,
                    palavra_chave_5: null,
                    divisoes_tematicas: null,
                    file: null,
                    coautoresOrientadores: [{
                        id: null,
                        nome_completo: null,
                        categoria: null,
                        cpf: null,
                    }],
                    tipo: {
                        numero: this.tipo,
                        name: null,
                    },
                    _method: 'post'
                },
                options: [
                    { text: 'Não', value: 0 },
                    { text: 'Sim', value: 1 },
                ],
                titulacoes: [
                    { text: 'Selecione a Titulação', value: null },
                    { text: 'Estudante de Graduação', value: 1 },
                    { text: 'Bacharel', value: 2 },
                    { text: 'Livre Docente', value: 3 },
                    { text: 'Mestrando', value: 4 },
                    { text: 'Doutorando', value: 5 },
                    { text: 'Mestre', value: 6 },
                    { text: 'Doutor', value: 7 },
                    { text: 'Cursando Especialização', value: 8 },
                    { text: 'Especialista', value: 9 },
                    { text: 'Licenciado', value: 10 }
                ],
            }
        },
        watch: {
            user(){
                if(this.user){
                    this.$forceUpdate()
                    this.post._method = "post",
                    this.post.id = this.user && this.user.regional_sul && this.user.regional_sul.submissao ? this.user.regional_sul.submissao.id : null,
                    this.post.titulo = this.user && this.user.regional_sul && this.user.regional_sul.submissao ? this.user.regional_sul.submissao.titulo : null
                    this.post.palavra_chave_1 = this.user && this.user.regional_sul && this.user.regional_sul.submissao ? this.user.regional_sul.submissao.palavra_chave_1 : null
                    this.post.palavra_chave_2 = this.user && this.user.regional_sul && this.user.regional_sul.submissao ? this.user.regional_sul.submissao.palavra_chave_2 : null
                    this.post.palavra_chave_3 = this.user && this.user.regional_sul && this.user.regional_sul.submissao ? this.user.regional_sul.submissao.palavra_chave_3 : null
                    this.post.palavra_chave_4 = this.user && this.user.regional_sul && this.user.regional_sul.submissao ? this.user.regional_sul.submissao.palavra_chave_4 : null
                    this.post.palavra_chave_5 = this.user && this.user.regional_sul && this.user.regional_sul.submissao ? this.user.regional_sul.submissao.palavra_chave_5 : null
                    this.post.divisoes_tematicas = this.find_divisoes_tematicas
                    this.post.file = this.user && this.user.regional_sul && this.user.regional_sul.submissao ? this.user.regional_sul.submissao.file : null
                    this.post.coautoresOrientadores = this.find_couautores_orientadores
                }
            }
        },
        computed: {
            find_divisoes_tematicas() {
                return this.user && this.user.todos_divisoes_tematicas ? this.user.todos_divisoes_tematicas.map(res => res.id)  : []
            },
            find_couautores_orientadores() {
                return this.user && this.user.regional_sul && this.user.regional_sul.submissao ? this.user && this.user.regional_sul && this.user.regional_sul.submissao.coautor_orientador_sub_suls.map(res => res)  : []
            },
            estaCiente() {
                return this.ciente == true
            }
        },
        methods: {  
            async save() {                                        
                this.loading = true

                if(this.post.divisoes_tematicas.length > 1){
                        this.$notify({
                            group: "submit",
                            title: "Erro",
                            text: 'Selecione uma divisão temática apenas!',
                            type: "error"
                        })
                        this.loading = false
                        return

                }else{

                    await this.$validator.validateAll().then((valid) => {
                    if(valid) {                        
                        if(this.generateErr == true){

                            this.message('Limite excedido', 'Limite de 200 caracteres excedido!', 'error');

                            this.loading = false
                            return

                        } else{

                            this.message('Aguarde...', 'Estamos salvando suas informações', 'info');
                            setTimeout(() => {

                                let formData = new FormData()
                                formData.append('post', JSON.stringify(this.post));
                                formData.append('file', this.post.file)
                                formData.append('_method', 'post')

                                let urlSave = this.baseUrl+"/submissao/sul/save";

                                $.ajax({
                                    method: "POST",
                                    url: urlSave,
                                    headers: {
                                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                                    },
                                    data: formData,
                                    dataType: 'json',
                                    contentType: false,
                                    processData: false,
                                    success: (res) => {
                                        if (res.message == "error") {
                                            this.message("Erro", "Erro ao tentar salvar seus dados, tente novamente dentro de alguns minutos ","error");
                                            this.loading = false;

                                        } else {
                                            this.message(
                                                "Erro",
                                                "Erro ao tentar salvar seus dados, tente novamente dentro de alguns minutos ",
                                                "error"
                                                
                                            );
                                            this.loading = false;
                                        }
                                        this.message( "Sucesso", "Seus dados foram alterados com sucesso", "success");
                                        this.loading = false;

                                        window.location.href = "/home?status=sucess1";

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
                }
            },
            back(){
                window.history.back();
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
            liveCountDown: function() {
                this.totalRemainCount = this.limitmaxCount - this.post.titulo.length;
                this.generateErr = this.totalRemainCount < 0;
            },
            addCoaOri(){
                this.post.coautoresOrientadores.push({id: null, nome_completo:null, cpf:null, categoria: null});
            },
            removeCoaOri(index){
                if(this.post.coautoresOrientadores.length >= 1){
                    this.post.coautoresOrientadores.splice(index, 1);
                    this.$bvModal.hide('modal-deletar-coautores-orientadores')
                }
            },
            addFile(ev){
                this.post.file = ev.target.files[0];
                if(this.post.file) {
                    this.size_arquivos = 0
                    this.size_arquivos = this.post.file.size;
                }
            },
            tipos(){
                if(this.tipo){
                    if(this.tipo == 1){
                        this.post.tipo.numero = this.tipo
                        this.post.tipo.name = "Intercom Júnior"
                    }
                    if(this.tipo == 2){
                        this.post.tipo.numero = this.tipo
                        this.post.tipo.name = "Divisões Temáticas"
                    }
                    if(this.tipo == 3){
                        this.post.tipo.numero = this.tipo
                        this.post.tipo.name = "Mesa"
                    }
                    if(this.tipo == 4){
                        this.post.tipo.numero = this.tipo
                        this.post.tipo.name = "Expocom"
                    }
                }
                if(this.regiao){
                    if(this.regiao == 1){
                        this.post.tipo.regiao = "Sul"
                    }
                    if(this.regiao == 2){
                        this.post.tipo.regiao = "Nordeste"
                    }
                    if(this.regiao == 3){
                        this.post.tipo.regiao = "Suldeste"
                    }
                    if(this.regiao == 4){
                        this.post.tipo.regiao = "Centro-Oeste"
                    }
                    if(this.regiao == 5){
                        this.post.tipo.regiao = "Norte"
                    }
                }
            }
        },
        created() {
            this.getDivisoesTematicas()
        },
        mounted(){
            if(this.user){
                if(
                    this.user 
                    && this.user.regional_sul 
                    && this.user.regional_sul.submissao 
                    && this.user && this.user.regional_sul 
                    && this.user && this.user.regional_sul.submissao
                    && this.user.regional_sul.submissao.coautor_orientador_sub_suls.length > 0){

                    this.user.regional_sul.submissao.coautor_orientador_sub_suls.forEach((element, index) => {
                        this.post.coautoresOrientadores.push({
                            id: element.id,
                            nome_completo: element.nome_completo,
                            cpf: element.cpf,
                            categoria: element.categoria
                        });
                    });
                }

            }
        }
    }
</script>


<style scoped>
    ::v-deep .modal-backdrop {
        opacity: 0.5 !important;
    }
</style>
