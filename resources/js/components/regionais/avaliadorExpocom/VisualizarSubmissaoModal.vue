<template>
    <b-modal id="modalSub" size="lg" no-close-on-backdrop>
        <template #modal-header="{ close }">
            <h5>Resumo da Submissao</h5>
            <b-button size="sm" variant="outline-danger" @click="close()">X</b-button>
        </template>
        <template>

            <div class="text-center"><h6>Nome do Autor: {{ form ? form.nome_autor : "NI" }}</h6></div>
            <br><br>


            <div class="text-center"><h6>Descrição do objeto de estudo</h6></div>

            <b-form-textarea plaintext rows="8" :value="form ? form.desc_obj_estudo : 'NI'"></b-form-textarea>
            <br><br>

            <div class="text-center"><h6>Descrição das pesquisas realizadas</h6></div>

            <b-form-textarea plaintext rows="8" :value="form ? form.desc_pesquisa : 'NI'"></b-form-textarea>
            <br><br>

            <div class="text-center"><h6>Descrição da produção</h6></div>

            <b-form-textarea plaintext rows="8" :value="form ? form.desc_producao : 'NI'"></b-form-textarea>
            <br><br>

            <div class="text-center" v-if="form && form.coautores != null"><h6>Coautores</h6></div>

            <b-col cols="12" sm="12" lg="12" class="text-center" v-for="(coautor, indiceCoautorOrientador) in form.coautores" :key="indiceCoautorOrientador">
                <b-row>
                    <b-col cols="12" sm="6" lg="6" class="text-center mb-3">
                        <b-form-group label="Categoria" label-class="font-weight-bold">
                            <b-form-select
                                :disabled="true"
                                :name="`categoria${indiceCoautorOrientador}`"
                                size="sm"
                                data-vv-as="Categoria"
                                class="form-control form-control-sm"
                                v-model="form.coautores[indiceCoautorOrientador].categoria"
                            >
                                <option :value="null">Selecione a Titulação</option>
                                <option value="1">Coautor(a)</option>
                                <option value="2">Orientador(a)</option>
                            </b-form-select>
                        </b-form-group>
                    </b-col>

                    <b-col cols="12" sm="6" lg="6" class="text-center mb-3">
                        <b-form-group label="Nome completo" label-class="font-weight-bold">
                            <b-form-input
                                :name="`nome_completo${indiceCoautorOrientador}`"
                                size="sm"
                                v-model="form.coautores[indiceCoautorOrientador].nome_completo"
                                type="text"
                                :disabled="true"
                                :class="['form-control form-control-sm']"
                            ></b-form-input>
                        </b-form-group>
                    </b-col>

                </b-row>
            </b-col>

            <b-col cols="6" sm="6" lg="6">
                <b-form-group label="Ano letivo e/ou ano calendário da realização do trabalho:" label-class="font-weight-bold">
                    <b-form-input
                        name="ano"
                        size="sm"
                        v-model="form.ano"
                        type="text"
                        :disabled="true"
                    ></b-form-input>
                </b-form-group>
            </b-col>



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
                form : {
                    ano: null,
                    desc_obj_estudo: null,
                    desc_pesquisa: null,
                    desc_producao: null,
                    coautores: []
                },
            }
        },
        watch:{
            selectedSub(newVal){
                if(newVal){
                    this.form.ano = newVal.submissao.ano;
                    this.form.desc_obj_estudo = newVal.submissao.desc_obj_estudo;
                    this.form.desc_pesquisa = newVal.submissao.desc_pesquisa;
                    this.form.desc_producao = newVal.submissao.desc_producao;
                    this.form.nome_autor = newVal && newVal.submissao.inscricao && newVal.submissao.inscricao.user && newVal.submissao.inscricao.user.indicacao ? newVal.submissao.inscricao.user.indicacao.nome_autor : "NI"

                    if(newVal && newVal.submissao.coautor_orientador_sub_sudeste){
                        this.form.coautores = newVal.submissao.coautor_orientador_sub_sudeste;
                    }

                    if(newVal && newVal.submissao.coautor_orientador_sub_nordeste){
                        this.form.coautores = newVal.submissao.coautor_orientador_sub_nordeste;
                    }

                    if(newVal && newVal.submissao.coautor_orientador_sub_centro_oeste){
                        this.form.coautores = newVal.submissao.coautor_orientador_sub_centro_oeste;
                    }

                    if(newVal && newVal.submissao.coautor_orientador_sub_suls){
                        this.form.coautores = newVal.submissao.coautor_orientador_sub_suls;
                    }

                    if(newVal && newVal.submissao.coautor_orientador_sub_nortes){
                        this.form.coautores = newVal && newVal.submissao ? newVal.submissao.coautor_orientador_sub_nortes : []
                    }
                     
                }
            }
        },
        methods: {
            find_dt(post){
                if(post && post.dt){
                    let selectedDt =  this.divisoes_tematicas.find(dt => dt.id === post.dt)
                    return selectedDt ? selectedDt.descricao : "NI"
                }
            } 
        },
    }
</script>

<style scoped>
    ::v-deep .modal-backdrop {
        opacity: 0.5 !important;
    }
</style>