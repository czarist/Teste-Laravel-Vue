<template>
    <b-modal id="modalVerJustificativa" size="xl" no-close-on-backdrop>
        <template #modal-header="{ close }">
            <h5>Justificativa do Coordenador</h5>
            <b-button size="sm" variant="outline-danger" @click="close()">X</b-button>
        </template>
        <template>
            <div class="text-center">
                <p>{{ selectedJustificativa && selectedJustificativa.avaliacao ? selectedJustificativa.avaliacao.justificativa_coordenador : "Sem Justificativa" }}</p>
            </div>

        </template>
    </b-modal>
</template>

<script>
export default {
    props: ['selectedJustificativa'],
    data(){
        return {
            loading: false,
            baseUrl: process.env.MIX_BASE_URL,

        }
    },
    computed: {
    },
    watch: {
    },
    methods: {
        close(){
            this.$refs.modalVerJustificativa.hide()
        }
    },
}
</script>

<style scoped>
    ::v-deep .modal-backdrop {
        opacity: 0.5 !important;
    }
</style>