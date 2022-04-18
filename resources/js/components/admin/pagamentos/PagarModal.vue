<template>
     <b-modal id="pagarModal" no-close-on-backdrop>
        <template #modal-header="{ close }">
            <h5>Alterar pagamento  ? </h5>
            <b-button size="sm" variant="outline-danger" :disabled="loading" @click="close()">x</b-button>
        </template>
        <template>
            <b-alert show variant="danger">
                <h5>ATENÇÃO!</h5>
                <p>
                <strong>Tem certeza que deseja confirmar este pagamento? </strong> Essa ação é irreversível!</p>

            </b-alert>
        </template>
        <template #modal-footer="{ cancel }">
            <b-button size="md" variant="outline-danger" :disabled="loading" @click="cancel()">
                Não
            </b-button>
             <b-button size="md" variant="outline-success"  @click="sendPag(selected.pagamento.id)">
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
        sendPag(id){          
            this.loading = true
            axios.get(`${this.baseUrl}/admin/pagamentos/pago/${id}`).then( res =>{
                    console.log(res)
                this.loading = false;
                if(res.data.success == true){
                    window.location.reload()
                }else{
                    this.message('Não foi possível atualizar os dados','error');
                }
            }).catch( e => {
                this.loading = false;
                this.message('Não foi possível atualizar os dados','error');
            })
        }
    },
}
</script>

<style scoped>
    ::v-deep .modal-backdrop {
        opacity: 0.5 !important;
    }
</style>