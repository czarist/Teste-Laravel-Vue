<template>
    <b-modal id="modalSub" size="lg" no-close-on-backdrop>
        <template #modal-header="{ close }">
            <h5>Resumo da Submissao</h5>
            <b-button size="sm" variant="outline-danger" @click="close()">X</b-button>
        </template>
        <template>

            <div class="text-center text-black"><h6 class="text-black">Nome do Autor: {{ form ? form.nome_autor : "NI" }}</h6></div>
            <br><br>

            <b-col cols="12" sm="12" lg="12" class="text-center mb-3 text-black">
                <b-form-group label="Instituição:" label-class="font-weight-bold text-black ">
                    <b-form-select
                        :disabled="true"
                        name="instituicao"
                        v-validate="{ required: true }"
                        :class="['form-control form-control-sm text-black', {'is-invalid': errors.has(`instituicao`)}]"
                        size="sm"
                        data-vv-as="Instituição:"
                        class="form-control form-control-sm"
                        v-model="form.instituicao_id"
                    >
                    <option v-for="instituicao in instituicoes" :value="instituicao.id" :key="instituicao.id">
                        {{ instituicao.instituicao }} - {{ instituicao.sigla_instituicao }}
                    </option>
                    </b-form-select>
                </b-form-group>
            </b-col>
            <br><br>
            
            <div class="text-center text-black">
                <h6
                    class="text-black"
                >
                    Categoria - Modalidade:
                </h6>
                <h6
                    class="text-black"
                    >{{ form ? form.categoria : "Nenhuma Informação" }} - {{ form ? form.modalidade : "Nenhuma Informação" }}
                </h6>
            </div>          
            <br><br>


            <div class="text-center text-black">
                <h6
                    class="text-black"
                >
                    Título do Trabalho:
                </h6>
                <h6
                    class="text-black"
                    >{{ form ? form.titulo : "Nenhuma Informação" }}
                </h6>
            </div>          
            <br><br>

            <div class="text-center text-black">
                <h6
                    class="text-black"
                >
                    Trabalho produzido em:
                </h6>
                <h6
                    class="text-black"
                    >{{ form ? form.trabalho_produzido : "Nenhuma Informação" }}
                </h6>
            </div>          
            <br><br>

            <div class="text-center"><h6>Descrição do objeto de estudo</h6></div>

            <b-form-textarea class="text-black" plaintext rows="8" :value="form ? form.desc_obj_estudo : 'NI'"></b-form-textarea>
            <br><br>

            <div class="text-center"><h6>Descrição das pesquisas realizadas</h6></div>

            <b-form-textarea class="text-black" plaintext rows="8" :value="form ? form.desc_pesquisa : 'NI'"></b-form-textarea>
            <br><br>

            <div class="text-center"><h6>Descrição da produção</h6></div>

            <b-form-textarea class="text-black" plaintext rows="8" :value="form ? form.desc_producao : 'NI'"></b-form-textarea>
            <br><br>

            <div class="text-center" v-if="form && form.coautores != null"><h6>Coautores</h6></div>

                <b-row>

                    <b-col cols="12" sm="12" lg="12" class="text-center" v-for="(coautor, indiceCoautorOrientador) in form.coautores" :key="indiceCoautorOrientador">
                        <b-row>
                            <b-col cols="12" sm="6" lg="6" class="text-center mb-3">
                                <b-form-group label="Categoria" label-class="font-weight-bold text-black">
                                    <b-form-select
                                        :disabled="true"
                                        :name="`categoria${indiceCoautorOrientador}`"
                                        size="sm"
                                        data-vv-as="Categoria"
                                        class="form-control form-control-sm text-black"
                                        v-model="form.coautores[indiceCoautorOrientador].categoria"
                                    >
                                        <option :value="null">Selecione a Titulação</option>
                                        <option value="1">Coautor(a)</option>
                                        <option value="2">Orientador(a)</option>
                                    </b-form-select>
                                </b-form-group>
                            </b-col>

                            <b-col cols="12" sm="6" lg="6" class="text-center mb-3 text-black">
                                <b-form-group label="Nome completo" label-class="font-weight-bold text-black">
                                    <b-form-input
                                        :name="`nome_completo${indiceCoautorOrientador}`"
                                        size="sm"
                                        v-model="form.coautores[indiceCoautorOrientador].nome_completo"
                                        type="text"
                                        :disabled="true"
                                        class="form-control form-control-sm text-black"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>

                        </b-row>
                    </b-col>

                    <b-col cols="6" sm="6" lg="6" class="text-center mb-3 text-black">
                        <b-form-group label="Ano letivo e/ou ano calendário da realização do trabalho:" label-class="font-weight-bold text-black">
                            <b-form-input
                                name="ano"
                                size="sm"
                                v-model="form.ano"
                                type="text"
                                class="text-black"
                                :disabled="true"
                            ></b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>


        </template>
            <template #modal-footer="{ cancel }">
                <b-button size="md" variant="outline-danger" @click="cancel()" :disabled="loading">
                    Cancelar
                </b-button>
        </template>
    </b-modal>
</template>

<script>
  import MixinsGlobal from  '../../mixins/global-mixins'
      export default {
        props: ['selectedSub'],
        mixins: [
            MixinsGlobal
        ],
        data() {
            return {
                baseUrl: process.env.MIX_BASE_URL,
                instituicoes: [],
                form : {
                    ano: null,
                    desc_obj_estudo: null,
                    desc_pesquisa: null,
                    desc_producao: null,
                    instituicao_id: null,
                    coautores: [],
                    categoria: null,
                    modalidade: null,
                    titulo: null,
                    trabalho_produzido: null,
                },
            }
        },
        watch:{
            selectedSub(newVal){
                if(newVal){
                    this.form.ano = newVal.ano
                    this.form.desc_obj_estudo = newVal.desc_obj_estudo
                    this.form.desc_pesquisa = newVal.desc_pesquisa
                    this.form.desc_producao = newVal.desc_producao
                    this.form.nome_autor = newVal && newVal.inscricao && newVal.inscricao.user && newVal.inscricao.user.indicacao ? newVal.inscricao.user.indicacao.nome_autor : "NI"
                    this.form.instituicao_id = newVal.inscricao && newVal.inscricao.user && newVal.inscricao.user.indicacao ? newVal.inscricao.user.indicacao.instituicao_id : null
                    this.form.modalidade = newVal.inscricao && newVal.inscricao.user && newVal.inscricao.user.indicacao ? newVal.inscricao.user.indicacao.modalidade : null
                    this.form.categoria = newVal.inscricao && newVal.inscricao.user && newVal.inscricao.user.indicacao ? newVal.inscricao.user.indicacao.categoria : null
                    this.form.titulo = newVal.inscricao && newVal.inscricao.user && newVal.inscricao.user.indicacao ? newVal.inscricao.user.indicacao.titulo_trabalho : null
                    this.form.trabalho_produzido = newVal.inscricao && newVal.inscricao.user && newVal.inscricao.user.indicacao ? newVal.inscricao.user.indicacao.trabalho_produzido : null

                    if(newVal && newVal.coautor_orientador_sub_sudeste){
                        this.form.coautores = newVal.coautor_orientador_sub_sudeste;
                    }

                    if(newVal && newVal.coautor_orientador_sub_nordeste){
                        this.form.coautores = newVal.coautor_orientador_sub_nordeste;
                    }

                    if(newVal && newVal.coautor_orientador_sub_centrooeste){
                        this.form.coautores = newVal.coautor_orientador_sub_centrooeste;
                    }

                    if(newVal && newVal.coautor_orientador_sub_suls){
                        this.form.coautores = newVal.coautor_orientador_sub_suls;
                    }

                    if(newVal && newVal.coautor_orientador_sub_nortes){
                        this.form.coautores = newVal.coautor_orientador_sub_nortes;
                    }
                     
                }
            }
        },
        methods: {
            getInstituicoes(){
                let urlGetInstituicoes = this.baseUrl+'/get/instituicoes';
                $.ajax({
                    method: "GET",
                    url: urlGetInstituicoes,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.instituicoes = res
                    },
                    error: (res) => {
                        console.log(res)
                        
                    }
                }); 
            }
        },
        created() {
            this.getInstituicoes()
        }
    }
</script>

<style scoped>
    ::v-deep .modal-backdrop {
        opacity: 0.5 !important;
    }
</style>