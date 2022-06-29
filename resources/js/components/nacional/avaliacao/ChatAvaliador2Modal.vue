<template>
    <b-modal id="modalChatAvaliador2" size="xl" no-close-on-backdrop>
        <template #modal-header="{ close }">
            <h5>MENSAGENS PARA O AVALIADOR 2</h5>
            <b-button size="sm" variant="outline-danger" @click="close()">X</b-button>
        </template>
        <template>

            <div class="modal-body scroll pb-0" ref="scroll">
                <div v-for="(mensagem, indexMensagem) in mensagens" :key="indexMensagem">

                    <span
                        v-if="selectedChat.avaliacao.avaliador_2 == mensagem.avaliador_id ||
                        selectedChat.coordenador_id && mensagem.send_avaliador == 2
                        "
                        :class="
                            (mensagem && mensagem.coordenador  && mensagem.coordenador.user && mensagem.coordenador.user.id == user.id) ? `alert alert-info float-left mb-2 w-100`: 
                            (mensagem && mensagem.avaliador && mensagem.avaliador) ? `alert alert-danger float-right mb-2 w-100`: 
                            `alert alert-warning float-right mb-2 w-100`"

                        style="max-width:87% !important; border-radius:8px !important;" 
                    >
                        <div class="d-flex justify-content-between">
                            <span v-if="mensagem && mensagem.coordenador"> 
                                <b>{{ mensagem && mensagem.created_at | momentFullDate }} - {{ mensagem && mensagem.coordenador  && mensagem.coordenador.user ? mensagem.coordenador.user.name : 'Coordenador' }} - Coordenador</b> 
                            </span>

                            <span v-if="mensagem && mensagem.avaliado"> 
                                <b>{{ mensagem && mensagem.created_at | momentFullDate }} - Autor</b> 
                            </span>

                            <span v-if="mensagem && mensagem.avaliador"> 
                                <b>{{ mensagem && mensagem.created_at | momentFullDate }} - {{ mensagem && mensagem.avaliador ? mensagem.avaliador.name : 'Avaliador' }} - Avaliador</b> 
                            </span>

                        </div><br /><br />
                        <p>{{ mensagem ? mensagem.mensagem : null}}</p>
                    </span>

                </div>

                <div class="form-group">
                    <textarea 
                        @keydown.enter.exact.prevent
                        @keyup.enter.exact="send"
                        placeholder="Escreva a  mensagem"
                        class="form-control-sm form-control"  
                        :class="[{'is-invalid': errors.has('mensagem')}]"
                        name="mensagem"
                        rows="2"
                        :disabled="loading"
                        v-model="selectedChat.mensagem"
                        @input="autoResize"
                        v-validate="'required'"
                        data-vv-as="mensagem"
                    ></textarea>

                    <div class="invalid-feedback">
                        {{ errors.first('mensagem') }}
                    </div>
                </div>

            </div>

        </template>
            <template #modal-footer="{ cancel }">
                <b-button size="md" variant="outline-danger" @click="cancel()" :disabled="loading">
                    Cancelar
                </b-button>
                <b-button :disabled=" loading" size="md" variant="outline-success" @click="send()">
                    Enviar
                </b-button>
        </template>
    </b-modal>
</template>

<script>
export default {
    props: ['selectedChat','user', 'mensagens', 'scroll'],
    data(){
        return {
            loading: false,
            baseUrl: process.env.MIX_BASE_URL,
            dataScroll: false,
            moment: moment,
        }
    },
    computed: {
        initScroll(){
            if(this.dataScroll){
                this.$refs.scroll.scrollTop = this.$refs.scroll.scrollHeight
            }
        },
    },
    watch: {
        'scroll': function(val){
            this.dataScroll = val
        }
    },
    methods: {
        autoResize(event) {
            event.target.style.height = "auto"
            event.target.style.height = `${event.target.scrollHeight}px`
        },
        send(){
            this.$validator.validateAll().then(valid => {
                if (valid) {
                    this.loading = true;
                    axios.post(`${this.baseUrl}/coordenador/nacional/avaliador/send/message`, this.selectedChat).then( res =>{
                        this.loading = false;
                        if(res.status == 201){
                            this.mensagens.push(res.data);
                            this.selectedChat.mensagem = null;
                            this.$validator.reset('mensagem')
                            this.$refs['scroll'].scrollTop  = this.$refs['scroll'].scrollHeight;
                        }else{
                            this.message('Não foi possível', res.data, 'error');
                        }
                    }).catch( e => {
                        this.loading = false;
                        console.log(e);
                    });
                }
            })
        },
        cancel(){
            $('modalChatAvaliador2').modal('hide');
            this.destroyed()
            this.updateScroll()
        },
        destroyed () {
            this.dataScroll = false
        },
        updateScroll(){
            this.$emit('update:scroll', this.dataScroll)
        }    
    },
}
</script>

<style scoped>
    ::v-deep .modal-backdrop {
        opacity: 0.5 !important;
    }
</style>