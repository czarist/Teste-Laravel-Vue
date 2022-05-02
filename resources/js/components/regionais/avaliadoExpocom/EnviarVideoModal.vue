<template>
    <b-modal id="modalVideo" size="xl" no-close-on-backdrop>
        <template #modal-header="{ close }">
            <h5>Enviar video de aceite</h5>
            <b-button size="sm" variant="outline-danger" @click="close()">X</b-button>
        </template>
        <template>
            <div class="text-center">
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

                    </div>

                    <div class="card-footer ">
                        <div class="row text-center">
                            <div class="col-2">
                            </div>
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
                            <div class="col-2">
                                <b-button
                                    :disabled="loading || size_arquivos > total_size"
                                    size="md" 
                                    variant="outline-success" 
                                    class="align-self-end m-1" @click="save()">
                                    Enviar arquivo
                                </b-button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </b-modal>
</template>

<script>
export default {
    props: ['selectedVideo'],
    data(){
        return {
            loading: false,
            baseUrl: process.env.MIX_BASE_URL,
            total_size: 2097152,
            size_arquivos: 0,
            post:{
                id: this.selectedVideo ? this.selectedVideo.id : null,
                file: this.selectedVideo ? this.selectedVideo.link_aceite: null,            
            }
        }
    },
    computed: {
    },
    watch: {
    },
    methods: {
        close(){
            this.$refs.modalVerJustificativa.hide()
        },
        addFile(ev){
            this.post.file = ev.target.files[0];
            if(this.post.file) {
                this.size_arquivos = 0
                this.size_arquivos = this.post.file.size;
            }
        },
        save(){
            this.$emit('save', this.post)
        }
    },
}
</script>

<style scoped>
    ::v-deep .modal-backdrop {
        opacity: 0.5 !important;
    }
</style>