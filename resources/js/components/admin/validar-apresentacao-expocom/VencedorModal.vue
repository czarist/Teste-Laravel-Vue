<template>
     <b-modal id="vencedorModal" no-close-on-backdrop>
        <template #modal-header="{ close }">
            <h5>Confirmar Vencedor ? </h5>
            <b-button size="sm" variant="outline-danger" :disabled="loading" @click="close()">x</b-button>
        </template>
        <template>
            <b-alert show variant="danger">
                <h5>ATENÇÃO!</h5>
                <p>
                <strong>Tem certeza que deseja confirmar que foi vercedor da categoria ? </strong> Essa ação é irreversível!</p>

            </b-alert>
        </template>
        <template #modal-footer="{ cancel }">
            <b-button size="md" variant="outline-danger" :disabled="loading" @click="cancel()">
                Não
            </b-button>
             <b-button size="md" variant="outline-success"  @click="confirmar(selected)">
                Sim
            </b-button>
        </template>
    </b-modal>
    
</template>

<script>
export default {
    props: ['selected'],
    data() {
        return {
            loading: false,
            baseUrl: process.env.MIX_BASE_URL,
        }
    },
    methods: {
        destroy(){
            this.$emit('destroy')
        },
        confirmar(selected){          
            this.loading = true

            axios.post(`${process.env.MIX_BASE_URL}/validar-apresentacao-expocom/confirmar_vencedor`, selected).then( res => {
                this.loading = false;
                if(res.status == 200){

                    this.$emit('store', res.data.response)
                    
                    this.$notify({
                        group: "submit",
                        title: "Sucesso!",
                        text: "Vencedor confirmada.",
                        type: "success"
                    })
                }
                
            }).catch(error => {
                this.loading = false;
                if(error.response.status == 422) {
                    if(error.response.data.message == "The given registro was invalid.") {
                        this.$notify({
                            group: "submit",
                            title: "Erro no cadastro",
                            text: "Campos obrigatórios não preenchidos.",
                            type: "error"
                        })
                    }
                }
                if(error.response.status == 403) {
                    if(error.response.data.message == "This action is unauthorized.") {
                        this.$notify({
                            group: "submit",
                            title: "Erro!",
                            text: "Ação não autorizada.",
                            type: "error"
                        })
                    }
                }
            });
        }
    },
}
</script>

<style scoped>
    ::v-deep .modal-backdrop {
        opacity: 0.5 !important;
    }
</style>