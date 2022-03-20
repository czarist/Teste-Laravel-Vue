<template>

<div>
    <div class="row justify-content-center" v-on="this.tipos()" v-show="this.edit">
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

                        <hr>
                        <hr>

                        <b-col cols="12" sm="12" lg="12" class="text-center">
                            <b-row>
                                <b-col cols="6" sm="6" lg="6">
                                    <b-form-invalid-feedback v-if="acordoTermoAutoria == 0" class="text-center">Declare que esta de acordo com termo de autoria</b-form-invalid-feedback>

                                    <b-form-checkbox
                                        id="termo_autoria"
                                        v-model="post.termo_autoria"
                                        name="termo_autoria"
                                        :value="1"
                                        :unchecked-value="2"
                                        :acordoTermoAutoria="acordoTermoAutoria"
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

                                    <b-form-invalid-feedback v-if="acordoAutorizacao == 0" class="text-center">Declare que esta de acordo com a autorização</b-form-invalid-feedback>

                                    <b-form-checkbox
                                        id="autorizacao"
                                        v-model="post.autorizacao"
                                        name="autorizacao"
                                        :value="1"
                                        :unchecked-value="2"
                                        :acordoAutorizacao="acordoAutorizacao"
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

    <div class="row justify-content-center" v-on="this.tipos()" v-if="!this.edit">
        <div class="card mt-3">
            <div class="card-header text-center">
                <div class="text-center">
                    <b-button size="lg" variant="primary" @click="clickEdit()">EDITAR</b-button>
                </div>
            </div>

            <div class="card-body">
                <b-row>
                    <b-col cols="12" sm="6" lg="6">
                        <b-form-group label="Título:" label-class="font-weight-bold">
                            <p>{{ this.post ? this.post.titulo : "NI"  }}</p>
                        </b-form-group>
                    </b-col>

                    <b-col cols="12" sm="6" lg="6">
                        <b-form-group label="Palavras-Chaves:" label-class="font-weight-bold">
                            <p>{{ this.post ? this.post.palavra_chave_1 : "NI" }}</p>
                            <p>{{ this.post ? this.post.palavra_chave_2 : "NI" }}</p>
                            <p>{{ this.post ? this.post.palavra_chave_3 : "NI" }}</p>
                            <p>{{ this.post ? this.post.palavra_chave_4 : "NI" }}</p>
                            <p>{{ this.post ? this.post.palavra_chave_5 : "NI" }}</p>

                        </b-form-group>
                    </b-col>
                    <b-col cols="12" sm="12" lg="12">
                        <b-form-group label="ANEXO:" label-class="font-weight-bold">
                            <button
                                v-tooltip.bottom="{
                                content: 'Visualizar Anexo',
                                delay: 0,
                                class: 'tooltip-custom tooltip-arrow'
                                }"
                                title="Visualizar Anexo"
                                class="btn btn-lg btn-primary  mb-2"
                                @click="visualizarAnexo()"
                            >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM1.6 11.85H0v3.999h.791v-1.342h.803c.287 0 .531-.057.732-.173.203-.117.358-.275.463-.474a1.42 1.42 0 0 0 .161-.677c0-.25-.053-.476-.158-.677a1.176 1.176 0 0 0-.46-.477c-.2-.12-.443-.179-.732-.179Zm.545 1.333a.795.795 0 0 1-.085.38.574.574 0 0 1-.238.241.794.794 0 0 1-.375.082H.788V12.48h.66c.218 0 .389.06.512.181.123.122.185.296.185.522Zm1.217-1.333v3.999h1.46c.401 0 .734-.08.998-.237a1.45 1.45 0 0 0 .595-.689c.13-.3.196-.662.196-1.084 0-.42-.065-.778-.196-1.075a1.426 1.426 0 0 0-.589-.68c-.264-.156-.599-.234-1.005-.234H3.362Zm.791.645h.563c.248 0 .45.05.609.152a.89.89 0 0 1 .354.454c.079.201.118.452.118.753a2.3 2.3 0 0 1-.068.592 1.14 1.14 0 0 1-.196.422.8.8 0 0 1-.334.252 1.298 1.298 0 0 1-.483.082h-.563v-2.707Zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638H7.896Z"/>
                            </svg>   
                            VISUALIZAR TRABALHO                         
                            </button>
                        </b-form-group>
                    </b-col>

                </b-row>
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
                edit: false,
                ciente: false,
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
                submissao:null,
                post: {
                    file: this.submissao ? this.submissao.link_trabalho : null,
                    id: this.submissao ? this.submissao.id : null,
                    titulo: this.submissao ? this.submissao.titulo : null,
                    palavra_chave_1: this.submissao ? this.submissao.palavra_chave_1 : null,
                    palavra_chave_2: this.submissao ? this.submissao.palavra_chave_2 : null,
                    palavra_chave_3: this.submissao ? this.submissao.palavra_chave_3 : null,
                    palavra_chave_4: this.submissao ? this.submissao.palavra_chave_4 : null,
                    palavra_chave_5: this.submissao ? this.submissao.palavra_chave_5 : null,
                    divisoes_tematicas: this.find_divisoes_tematicas,
                    termo_autoria: this.submissao ? this.submissao.termo_autoria : 0,
                    autorizacao: this.submissao ? this.submissao.autorizacao : 0,
                    coautoresOrientadores: 
                        this.submissao 
                        && this.submissao.coautor_orientador_sub_nordeste
                        && this.submissao.coautor_orientador_sub_nordeste.length == 0 ?
                    [{
                        id: null,
                        nome_completo: null,
                        categoria: null,
                        cpf: null
                    }] : [],
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
                    this.post.divisoes_tematicas = this.find_divisoes_tematicas,
                    this.post.id = this.submissao ? this.submissao.id : null,
                    this.post.titulo = this.submissao ? this.submissao.titulo : null
                    this.post.palavra_chave_1 = this.submissao ? this.submissao.palavra_chave_1 : null
                    this.post.palavra_chave_2 = this.submissao ? this.submissao.palavra_chave_2 : null
                    this.post.palavra_chave_3 = this.submissao ? this.submissao.palavra_chave_3 : null
                    this.post.palavra_chave_4 = this.submissao ? this.submissao.palavra_chave_4 : null
                    this.post.palavra_chave_5 = this.submissao ? this.submissao.palavra_chave_5 : null
                    this.post.file = this.submissao ? this.submissao.link_trabalho : null
                    this.post.autorizacao = this.submissao ? this.submissao.autorizacao : 0
                    this.post.termo_autoria = this.submissao ? this.submissao.termo_autoria : 0

                }
            }
        },
        computed: {
            find_divisoes_tematicas() {
                return this.user && this.user.todos_divisoes_tematicas ? this.user.todos_divisoes_tematicas.map(res => res.id)  : []
            },
            estaCiente() {
                return this.ciente == true
            },
            acordoTermoAutoria() {
                return this.post.termo_autoria == 1
            },
            acordoAutorizacao() {
                return this.post.autorizacao == 1
            }
        },
        methods: {  
            async save() {                                        
                this.loading = true

                if(this.post.divisoes_tematicas.length > 1){
                        this.message('Erro', 'Selecione uma divisão temática apenas!', 'error');
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

                                let urlSave = this.baseUrl+"/submissao/nordeste/save";

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
            visualizarAnexo(){
                window.open(this.baseUrl+'/pdf/submissao_regional_nordeste_2022/'+this.post.file);
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
                        this.post.tipo.regiao = "Sudeste"
                    }
                    if(this.regiao == 4){
                        this.post.tipo.regiao = "Centro-Oeste"
                    }
                    if(this.regiao == 5){
                        this.post.tipo.regiao = "Norte"
                    }
                }
            },
            clickEdit(){
                return this.edit = true
            }
        },
        created() {
            this.getDivisoesTematicas()
        },
        mounted(){
            if(this.user){

                if(this.user && this.user.regional_nordeste && this.user.regional_nordeste.submissao_dt && this.tipo == 2){
                    this.submissao = this.user.regional_nordeste.submissao_dt
                }

                if(this.user && this.user.regional_nordeste && this.user.regional_nordeste.submissao_junior && this.tipo == 1){
                    this.submissao = this.user.regional_nordeste.submissao_junior
                }

                if(this.user && this.user.regional_nordeste && this.user.regional_nordeste.submissao_mesa && this.tipo == 3){
                    this.submissao = this.user.regional_nordeste.submissao_mesa
                }

                this.edit = this.submissao == null  ? true : false

                if(
                    this.submissao 
                    && this.submissao.coautor_orientador_sub_nordeste
                    && this.submissao.coautor_orientador_sub_nordeste.length > 0){

                    this.submissao.coautor_orientador_sub_nordeste.forEach((element, index) => {
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
