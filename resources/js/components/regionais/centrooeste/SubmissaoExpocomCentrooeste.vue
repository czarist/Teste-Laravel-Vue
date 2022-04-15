<template>

<div>
    <div class="row justify-content-center" v-on="this.tipos()" v-if="this.edit">
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
                </div>

                <div class="card-body">
                    <b-row>
                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group label="Instituição" label-class="font-weight-bold">
                                <b-form-select
                                    :disabled="true"
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
                                    {{ instituicao.instituicao }}
                                </option>
                                </b-form-select>
                                <span v-show="errors.has(`instituicao`)" class="invalid-feedback">
                                    {{ errors.first(`instituicao`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group label="Campus" label-class="font-weight-bold">
                                <b-form-input
                                    name="campus"
                                    size="sm"
                                    v-model="post.campus"
                                    type="text"
                                    :disabled="loading"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`campus`)}]"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="Campus"
                                    v-validate="{ required: true }"
                                ></b-form-input>
                                <span v-show="errors.has(`campus`)" class="invalid-feedback">
                                    {{ errors.first(`campus`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label class="font-weight-bold">Estado</label>
                            <v-select
                            class="flex-fill"
                            :options="estados"
                            data-vv-as="estado"
                            :selectOnTab="true"
                            v-model="post.enderecos.estado"
                            v-validate="{ required: true }"
                            :disabled="true"
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
                            :disabled="true"
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
                    </b-row>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header text-center">
                </div>

                <div class="card-body">
                    <b-row>
                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group label="Categoria:" label-class="font-weight-bold">
                                <b-form-select
                                    :disabled="true"
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
                                    <option value=">Rádio, TV e Internet">Rádio, TV e Internet</option>
                                    <option value="Relações Públicas">Relações Públicas</option>

                                </b-form-select>
                                <span v-show="errors.has(`categoria`)" class="invalid-feedback">
                                    {{ errors.first(`categoria`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <div class="form-group col-12 col-md-6 col-sm-6 col-lg-6">
                            <label class="font-weight-bold">Modalidade:</label>
                            <v-select
                            class="flex-fill"
                            :name="`modalidade`"
                            :disabled="true"
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

                        <b-col cols="12" sm="6" lg="12" class="text-center">
                            <b-form-group label="Título do trabalho:" style="font-size:20px !important; color:black;">
                                    <textarea
                                        :disabled="true"
                                        class="form-control" 
                                        v-model="post.titulo" 
                                        name="titulo"
                                        :class="['form-control form-control-sm', {'is-invalid': errors.has(`titulo`)}]"
                                        v-validate="{ required: true }"
                                        ></textarea>
                                <span v-show="errors.has(`titulo`)" class="invalid-feedback">
                                    {{ errors.first(`titulo`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="6">
                            <b-form-group label="Ano letivo e/ou ano calendário da realização do trabalho:" label-class="font-weight-bold">
                                <b-form-input
                                    name="ano"
                                    size="sm"
                                    v-model="post.ano"
                                    type="text"
                                    :disabled="loading"
                                    v-mask="['####']"
                                    :class="['form-control form-control-sm', {'is-invalid': errors.has(`ano`)}]"
                                    aria-describedby="input-1-live-feedback"
                                    data-vv-as="Ano da realização do trabalho"
                                    v-validate="{ required: true }"
                                ></b-form-input>
                                <span v-show="errors.has(`ano`)" class="invalid-feedback">
                                    {{ errors.first(`ano`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                    </b-row>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header text-center">
                </div>

                <div class="card-body">
                    <b-row>
                        <b-col cols="12" sm="6" lg="12" class="text-center">
                            <b-form-group label="Descrição do objeto de estudo" style="font-size:20px !important; color:black;">
                                    <textarea 
                                        rows="8"
                                        class="form-control" 
                                        v-on:keyup="ContagemRegressivaObjEstudo" 
                                        v-model="post.desc_obj_estudo" 
                                        name="desc_obj_estudo"
                                        :class="['form-control form-control-sm', {'is-invalid': errors.has(`desc_obj_estudo`)}]"
                                        v-validate="{ required: true }"
                                        ></textarea>

                                        <p 
                                            v-if="post.desc_obj_estudo && post.desc_obj_estudo.length <= 400"
                                            >Minimo de caracteres restante: <span v-bind:class="{'text-danger': erro_cont_min_desc_obj_estudo }">{{totalMinCount_desc_obj_estudo}}</span></p>
                                        <p>Total caracteres restante: <span v-bind:class="{'text-danger': generateErr_desc_obj_estudo }">{{totalRemainCount_desc_obj_estudo}}</span></p>

                                <span v-show="errors.has(`desc_obj_estudo`)" class="invalid-feedback">
                                    {{ errors.first(`desc_obj_estudo`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="12" class="text-center">
                            <b-form-group label="Descrição das pesquisas realizadas:" style="font-size:20px !important; color:black;">
                                    <textarea 
                                        rows="8"
                                        class="form-control" 
                                        v-on:keyup="ContagemRegressivaPesquisa" 
                                        v-model="post.desc_pesquisa" 
                                        name="desc_pesquisa"
                                        :class="['form-control form-control-sm', {'is-invalid': errors.has(`desc_pesquisa`)}]"
                                        v-validate="{ required: true }"
                                        ></textarea>

                                        <p 
                                            v-if="post.desc_pesquisa && post.desc_pesquisa.length <= 400"
                                            >Minimo de caracteres restante: 
                                            <span 
                                                v-bind:class="{'text-danger': erro_cont_min_desc_pesquisa }">
                                                {{totalMinCount_desc_pesquisa}}
                                            </span>
                                        </p>

                                        <p>Total caracteres restante: <span v-bind:class="{'text-danger': generateErr_desc_pesquisa }">{{totalRemainCount_desc_pesquisa}}</span></p>

                                <span v-show="errors.has(`desc_pesquisa`)" class="invalid-feedback">
                                    {{ errors.first(`desc_pesquisa`) }}
                                </span>
                            </b-form-group>
                        </b-col>

                        <b-col cols="12" sm="6" lg="12" class="text-center">
                            <b-form-group label="Descrição da produção:" style="font-size:20px !important; color:black;">
                                    <textarea 
                                        rows="8"
                                        class="form-control" 
                                        v-on:keyup="ContagemRegressivaProducao" 
                                        v-model="post.desc_producao" 
                                        name="desc_producao"
                                        :class="['form-control form-control-sm', {'is-invalid': errors.has(`desc_producao`)}]"
                                        v-validate="{ required: true }"
                                        ></textarea>

                                        <p 
                                            v-if="post.desc_producao && post.desc_producao.length <= 400"
                                            >Minimo de caracteres restante: 
                                            <span 
                                                v-bind:class="{'text-danger': erro_cont_min_desc_producao }">
                                                {{totalMinCount_desc_producao}}
                                            </span>
                                        </p>

                                        <p>Total caracteres restante: <span v-bind:class="{'text-danger': generateErr_desc_producao }">{{totalRemainCount_desc_producao}}</span></p>

                                <span v-show="errors.has(`desc_producao`)" class="invalid-feedback">
                                    {{ errors.first(`desc_producao`) }}
                                </span>
                            </b-form-group>
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

                                    <b-col cols="12" sm="6" lg="6">
                                        <b-form-group label="Curso do(a) coautor(a):" label-class="font-weight-bold">
                                            <b-form-input
                                                :name="`curso_coautor${indiceCoautorOrientador}`"
                                                size="sm"
                                                v-model="post.coautoresOrientadores[indiceCoautorOrientador].curso_coautor"
                                                type="text"
                                                :disabled="loading"
                                                :class="['form-control form-control-sm', {'is-invalid': errors.has(`curso_coautor${indiceCoautorOrientador}`)}]"
                                                aria-describedby="input-1-live-feedback"
                                                data-vv-as="Curso do(a) coautor(a)"
                                                v-validate="{ required: true }"
                                            ></b-form-input>
                                            <span v-show="errors.has(`curso_coautor${indiceCoautorOrientador}`)" class="invalid-feedback">
                                                {{ errors.first(`curso_coautor${indiceCoautorOrientador}`) }}
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

                    <b-col cols="12" sm="12" lg="12" class="text-center m-3">
                        <b-row>
                            <b-col cols="4" sm="4" lg="4">
                                <b-form-invalid-feedback v-if="acordoTermoAutoria == 0" class="text-center">Declare que esta de acordo com termo de autoria</b-form-invalid-feedback>

                                <b-form-checkbox
                                    id="termo_autoria"
                                    v-model="post.termo_autoria"
                                    name="termo_autoria"
                                    :value="1"
                                    :unchecked-value="0"
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

                            <b-col cols="4" sm="4" lg="4">

                                <b-form-invalid-feedback v-if="acordoAutorizacao == 0" class="text-center">Declare que esta de acordo com a autorização</b-form-invalid-feedback>

                                <b-form-checkbox
                                    id="autorizacao"
                                    v-model="post.autorizacao"
                                    name="autorizacao"
                                    :value="1"
                                    :unchecked-value="0"
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

                            <b-col cols="4" sm="4" lg="4">
                                <b-form-invalid-feedback v-if="estaCiente == 0" class="text-center">Declare que esta ciente</b-form-invalid-feedback>

                                <b-form-checkbox
                                    id="ciente"
                                    v-model="post.ciente"
                                    name="ciente"
                                    :value="1"
                                    :unchecked-value="0"
                                    :estaCiente="estaCiente"                            
                                    data-vv-as="Declaro estar ciente"
                                    v-validate="{ required: true }"

                                    class="m-3"
                                    >
                                    Declaro estar ciente de que o link deverá estar acessível durante o período do Expocom, até a etapa nacional.
                                </b-form-checkbox>
                            </b-col>
                        </b-row>
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
                        <b-form-group label="Categoria:" label-class="font-weight-bold">
                            <p>{{ this.post ? this.post.categoria : "NI" }}</p>
                        </b-form-group>
                    </b-col>

                    <b-col cols="12" sm="6" lg="6">
                        <b-form-group label="Modalidade:" label-class="font-weight-bold">
                            <p>{{ this.post ? this.post.modalidade : "NI" }}</p>
                        </b-form-group>
                    </b-col>

                    <b-col cols="12" sm="6" lg="6">
                        <b-form-group label="Ano letivo e/ou ano calendário da realização do trabalho:" label-class="font-weight-bold">
                            <p>{{ this.post ? this.post.ano : "NI" }}</p>
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
                edit: this.user && this.user.regional_centrooeste && this.user.regional_centrooeste && this.user.regional_centrooeste.submissao_expocom ? false : true,
                indicacao: [],
                titulacoes: [],
                instituicoes: [],
                modalidades: [],
                estados: [],
                municipios: [],
                loading: false,
                verify: null,
                //Contagem regressiva 
                limitmaxCount_desc_obj_estudo: 4000,
                totalRemainCount_desc_obj_estudo: 4000,

                limitmaxCount_desc_pesquisa: 4000,
                totalRemainCount_desc_pesquisa: 4000,

                limitmaxCount_desc_producao: 4000,
                totalRemainCount_desc_producao: 4000,

                generateErr_desc_obj_estudo: false,
                generateErr_desc_pesquisa: false,
                generateErr_desc_producao: false,

                //Contagem de caracteres minimos
                limit_min_count_desc_obj_estudo: 400,
                limit_min_count_desc_pesquisa: 400,
                limit_min_count_desc_producao: 400,

                totalMinCount_desc_obj_estudo: 400,
                totalMinCount_desc_pesquisa: 400,
                totalMinCount_desc_producao: 400,

                erro_cont_min_desc_obj_estudo: false,
                erro_cont_min_desc_pesquisa: false,
                erro_cont_min_desc_producao: false,

                total_size: 2097152,
                size_arquivos: 0,
                deleteSelectCoautoresOrientadores: { indice: null},
                post: {
                    id: this.user && this.user.regional_centrooeste && this.user.regional_centrooeste.submissao_expocom ? this.user.regional_centrooeste.submissao_expocom.id : null,
                    titulo: this.indicacao ? this.indicacao.titulo_trabalho : null,
                    ano: this.user && this.user.regional_centrooeste && this.user.regional_centrooeste.submissao_expocom ? this.user.regional_centrooeste.submissao_expocom.ano : null,
                    instituicao_id: this.indicacao ? this.indicacao.instituicao_id : null,
                    campus: this.user && this.user.regional_centrooeste && this.user.regional_centrooeste.submissao_expocom ? this.user.regional_centrooeste.submissao_expocom.campus : null,
                    categoria: this.indicacao ? this.indicacao.categoria : null,
                    desc_obj_estudo: this.user && this.user.regional_centrooeste && this.user.regional_centrooeste.submissao_expocom ? this.user.regional_centrooeste.submissao_expocom.desc_obj_estudo : null,
                    desc_pesquisa: this.user && this.user.regional_centrooeste && this.user.regional_centrooeste.submissao_expocom ? this.user.regional_centrooeste.submissao_expocom.desc_pesquisa : null,
                    desc_producao: this.user && this.user.regional_centrooeste && this.user.regional_centrooeste.submissao_expocom ? this.user.regional_centrooeste.submissao_expocom.desc_producao : null,
                    file: this.user && this.user.regional_centrooeste && this.user.regional_centrooeste.submissao_expocom ? this.user.regional_centrooeste.submissao_expocom.link_trabalho : null,
                    modalidade: this.indicacao ? this.indicacao.modalidade : null,
                    termo_autoria: this.user && this.user.regional_centrooeste && this.user.regional_centrooeste.submissao_expocom ? this.user.regional_centrooeste.submissao_expocom.termo_autoria : 0,
                    autorizacao: this.user && this.user.regional_centrooeste && this.user.regional_centrooeste.submissao_expocom ? this.user.regional_centrooeste.submissao_expocom.autorizacao : 0,
                    ciente: this.user && this.user.regional_centrooeste && this.user.regional_centrooeste.submissao_expocom ? this.user.regional_centrooeste.submissao_expocom.ciente : 0,
                    enderecos: {
                        estado: null,
                        municipio: null
                    },
                    coautoresOrientadores: 
                        this.user 
                        && this.user.regional_centrooeste 
                        && this.user.regional_centrooeste.submissao_expocom 
                        && this.user.regional_centrooeste.submissao_expocom.coautor_orientador_sub_centrooeste
                        && this.user.regional_centrooeste.submissao_expocom.coautor_orientador_sub_centrooeste.length == 0 ?
                    [{
                        id: null,
                        nome_completo: null,
                        categoria: null,
                        cpf: null,
                        curso_coautor: null
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
                    this.post._method = "post"
                    this.post.id = this.user && this.user.regional_centrooeste && this.user.regional_centrooeste.submissao_expocom ? this.user.regional_centrooeste.submissao_expocom.id : null
                    this.post.ano = this.user && this.user.regional_centrooeste && this.user.regional_centrooeste.submissao_expocom ? this.user.regional_centrooeste.submissao_expocom.ano : null
                    this.post.desc_obj_estudo = this.user && this.user.regional_centrooeste && this.user.regional_centrooeste.submissao_expocom ? this.user.regional_centrooeste.submissao_expocom.desc_obj_estudo : null
                    this.post.desc_pesquisa = this.user && this.user.regional_centrooeste && this.user.regional_centrooeste.submissao_expocom ? this.user.regional_centrooeste.submissao_expocom.desc_pesquisa : null
                    this.post.desc_producao = this.user && this.user.regional_centrooeste && this.user.regional_centrooeste.submissao_expocom ? this.user.regional_centrooeste.submissao_expocom.desc_producao : null
                    this.post.campus = this.user && this.user.regional_centrooeste && this.user.regional_centrooeste.submissao_expocom ? this.user.regional_centrooeste.submissao_expocom.campus : null
                    this.post.file = this.user && this.user.regional_centrooeste && this.user.regional_centrooeste.submissao_expocom ? this.user.regional_centrooeste.submissao_expocom.link_trabalho : null
                }
            },
            indicacao(){
                if(this.indicacao){
                    this.$forceUpdate()
                    this.post.titulo = this.indicacao ? this.indicacao.titulo_trabalho : null
                    this.post.instituicao_id = this.indicacao ? this.indicacao.instituicao_id : null
                    this.post.categoria = this.indicacao ? this.indicacao.categoria : null
                    this.post.enderecos.municipio = this.indicacao && this.indicacao.enderecos ? this.indicacao.enderecos.municipio : null
                    this.post.enderecos.estado = this.indicacao && this.indicacao.enderecos && this.indicacao.enderecos.municipio ? this.indicacao.enderecos.municipio.estado : null
                    this.post.modalidade = this.indicacao ? this.indicacao.modalidade : null

                }
            }

        },
        computed: {
            estaCiente() {
                return this.post.ciente == 1
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
                await this.$validator.validateAll().then((valid) => {
                    if(valid) {                        
                        if(
                            this.generateErr_desc_obj_estudo == true 
                            || this.generateErr_desc_pesquisa == true 
                            || this.generateErr_desc_producao == true
                        ){

                            this.message('Limite excedido', 'Limite de 4000 caracteres excedido!', 'error');

                            this.loading = false
                            return

                        }else if(
                            this.erro_cont_min_desc_obj_estudo == true
                            || this.erro_cont_min_desc_pesquisa == true
                            || this.erro_cont_min_desc_producao == true
                        ){  
                            this.message('Minimo não alcançado ', 'Digite no minimo 400 caracteres!', 'error');

                            this.loading = false
                            return

                        } else{

                            this.message('Aguarde...', 'Estamos salvando suas informações', 'info');


                            setTimeout(() => {

                                let formData = new FormData()
                                formData.append('post', JSON.stringify(this.post));
                                formData.append('file', this.post.file)
                                formData.append('_method', 'post')

                                let urlSave = this.baseUrl+"/submissaoexpocom/centrooeste/save";

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
            },
            back(){
                window.history.back();
            },
            ContagemRegressivaObjEstudo: function() {
                this.totalRemainCount_desc_obj_estudo = this.limitmaxCount_desc_obj_estudo - this.post.desc_obj_estudo.length;
                this.generateErr_desc_obj_estudo = this.totalRemainCount_desc_obj_estudo < 0;

                this.totalMinCount_desc_obj_estudo = this.limit_min_count_desc_obj_estudo - this.post.desc_obj_estudo.length;
                this.erro_cont_min_desc_obj_estudo = this.totalMinCount_desc_obj_estudo > 0;

            },
            ContagemRegressivaPesquisa: function() {
                this.totalRemainCount_desc_pesquisa = this.limitmaxCount_desc_pesquisa - this.post.desc_pesquisa.length;
                this.generateErr_desc_pesquisa = this.totalRemainCount_desc_pesquisa < 0;

                this.totalMinCount_desc_pesquisa = this.limit_min_count_desc_pesquisa - this.post.desc_pesquisa.length;
                this.erro_cont_min_desc_pesquisa = this.totalMinCount_desc_pesquisa > 0;

            },
            ContagemRegressivaProducao: function() {
                this.totalRemainCount_desc_producao = this.limitmaxCount_desc_producao - this.post.desc_producao.length;
                this.generateErr_desc_producao = this.totalRemainCount_desc_producao < 0;

                this.totalMinCount_desc_producao = this.limit_min_count_desc_producao - this.post.desc_producao.length;
                this.erro_cont_min_desc_producao = this.totalMinCount_desc_producao > 0;

            },
            visualizarAnexo(){
                window.open(this.baseUrl+'/pdf/submissao_expocom_regional_centrooeste_2022/'+this.post.file);
            },
            addCoaOri(){
                this.post.coautoresOrientadores.push({id: null, nome_completo:null, cpf:null, categoria: null, curso_coautor:null});
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
            async getMunicipios() {
                if(this.post.enderecos && this.post.enderecos.estado) {

                    let urlgetMunicipios = this.baseUrl+`/get/municipios/${this.post.enderecos.estado.id}`;
                    await $.ajax({
                        method: "GET",
                        url: urlgetMunicipios,
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
                                estado: this.estados.find(uf => uf.sigla == res.uf),
                                municipio: null,

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
                        console.log(res)
                        
                    }
                }); 
            },
            getIndicacao(){

                let urlgetIndicacao = this.baseUrl+"/get/indicacao-expocom-2022";

                $.ajax({
                    method: "GET",
                    url: urlgetIndicacao,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.indicacao = res
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
            },
            getCinemaAudiovisual(){
                let urlgetCinemaAudiovisual = this.baseUrl+"/get/cinema-audiovisual";
                $.ajax({
                    method: "GET",
                    url: urlgetCinemaAudiovisual,
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
                let urlgetJornalismo = this.baseUrl+"/get/jornalismo";
                $.ajax({
                    method: "GET",
                    url: urlgetJornalismo,
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
                let urlgetPublicidadePropaganda = this.baseUrl+"/get/publicidade-propaganda";
                $.ajax({
                    method: "GET",
                    url: urlgetPublicidadePropaganda,
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
                let urlgetRelacoesPublicas = this.baseUrl+"/get/relacoes-publicas";
                $.ajax({
                    method: "GET",
                    url: urlgetRelacoesPublicas,
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
                let urlgetProdEdit = this.baseUrl+"/get/producao-editorial";
                $.ajax({
                    method: "GET",
                    url: urlgetProdEdit,
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
                let urlgetRadioInternet = this.baseUrl+"/get/radio-internet";
                $.ajax({
                    method: "GET",
                    url: urlgetRadioInternet,
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
            clickEdit(){
                return this.edit = true
            }

        },
        created() {
            this.getInstituicoes(),
            this.getEstados(),
            this.getIndicacao(),
            this.getCinemaAudiovisual(),
            this.getJornalismo(),
            this.getPublicidadePropaganda(),
            this.getRelacoesPublicas(),
            this.getProdEdit(),
            this.getRadioInternet()


        },
        mounted(){
            if(this.user){
                if(
                    this.user 
                    && this.user.regional_centrooeste 
                    && this.user.regional_centrooeste.submissao_expocom 
                    && this.user.regional_centrooeste.submissao_expocom.coautor_orientador_sub_centrooeste
                    && this.user.regional_centrooeste.submissao_expocom.coautor_orientador_sub_centrooeste.length > 0){

                    this.user.regional_centrooeste.submissao_expocom.coautor_orientador_sub_centrooeste.forEach((element, index) => {
                        this.post.coautoresOrientadores.push({
                            id: element.id,
                            nome_completo: element.nome_completo,
                            cpf: element.cpf,
                            categoria: element.categoria,
                            curso_coautor: element.curso_coautor
                        });
                    });
                }

            }

            // if(
            //     this.user 
            //     && this.user.regional_centrooeste 
            //     && this.user.regional_centrooeste.submissao_expocom
            //     && this.user.regional_centrooeste.submissao_expocom.avaliacao
            //     && this.user.regional_centrooeste.submissao_expocom.avaliacao.edit == 1
            // ){
            //     console.log('habilitado edição')

            // }else if(
            //     this.user 
            //     && this.user.regional_centrooeste 
            //     && this.user.regional_centrooeste.submissao_expocom
            //     && this.user.regional_centrooeste.submissao_expocom.avaliacao
            //     && this.user.regional_centrooeste.submissao_expocom.avaliacao.edit == 0
            // ){
            //     window.location.href = this.baseUrl+'/submissao-expocom'         
            // }
            // else if(
            //     this.user 
            //     && this.user.regional_centrooeste 
            //     && this.user.regional_centrooeste.submissao_expocom != null
            // ){
            //     window.location.href = this.baseUrl+'/submissao-expocom'        
            // }

        }
    }
</script>


<style scoped>
    ::v-deep .modal-backdrop {
        opacity: 0.5 !important;
    }
</style>
