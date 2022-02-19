<template>
     <b-modal id="deleteModal" no-close-on-backdrop>
        <template #modal-header="{ close }">
            <h5>Excluir registro  ? </h5>
            <b-button size="sm" variant="outline-danger" @click="close()">x</b-button>
        </template>
        <template>
            <b-alert show variant="danger">
                <h5>ATENÇÃO!</h5>
                <p>
                <strong>Essa ação é irreversível</strong>, não será possível recuperar esse registro!</p>
            </b-alert>
        </template>
        <template #modal-footer="{ ok, cancel }">
            <b-button size="md" variant="outline-danger" @click="cancel()">
                Não
            </b-button>
             <b-button size="md" variant="outline-success" @click="ok(),destroy()">
                Sim
            </b-button>
        </template>
    </b-modal>
    
</template>

<script>
export default {
    methods: {
        destroy(){
            this.$emit('destroy')
        }
    },
}
</script>