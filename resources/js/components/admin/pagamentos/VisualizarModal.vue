<template>
    <b-modal id="visualizarModal" no-close-on-backdrop >
        <template #modal-header="{ close }">
            <h5>Detalhes de Pagamento</h5>
            <b-button size="sm" variant="outline-danger" @click="close()">x</b-button>
        </template>
            <b-card>
                <b-card-text ><b>Data: {{ selected ? moment(selected.created_at).format('YYYY-MM-DD HH:mm') : "NI" }}</b></b-card-text>
                <b-card-text><b>Status: {{ selected && selected.pagamento ? selected.pagamento.status.nome : "NI" }}</b></b-card-text>
                <b-card-text><b>Transação: {{ selected && selected.pagamento? selected.pagamento.transacao : "NI" }}</b></b-card-text> 
                <!-- <b-card-text><b>Valor: {{ selected.vendas_item.valor_total | formatPrice }}</b></b-card-text> -->
                <b-card-text><b>Forma de Pagamento: {{ selected && selected.pagamento && selected.pagamento.tipo_pgto  ? selected.pagamento.tipo_pgto.nome : "NI" }}</b></b-card-text>    
                <b-card-text><b>Detalhe: {{ selected && selected.pagamento && selected.pagamento.tipo_pgto_detalhe  ? selected.pagamento.tipo_pgto_detalhe.nome : "NI" }}</b></b-card-text>
            </b-card>

            <table class="table table-sm table-striped table-hover table-bordered mt-3">
                <thead>
                    <tr>
                        <th class="align-middle text-center" width="10%">Produto</th>
                        <th class="align-middle text-center" width="10%">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="align-middle text-center">{{ selected && selected.vendas_item && selected.vendas_item.produto ? selected.vendas_item.produto.nome : "NI" }}</td>
                        <td class="align-middle text-center">{{ selected && selected.vendas_item && selected.vendas_item.produto ? selected.vendas_item.produto.valor : "NI" }}</td>
                    </tr>
                </tbody>
            </table>

        <template>

        </template>
            <template #modal-footer="{ cancel }">
                 <b-button size="md" variant="outline-danger" @click="cancel()" :disabled="loading">
                    Cancelar
                </b-button>
        </template>
    </b-modal>
</template>

<script>
    import moment from 'moment'

    export default {
        props: ['selected'],
        data() {
            return {
                loading: false,
                moment: moment,
            }
        },
        watch: {
        },
        computed: {
        },
        methods: {
        },
    }
</script>

<style scoped>
    ::v-deep .modal-backdrop {
        opacity: 0.5 !important;
    }
    ::v-deep .vue-notification {
        font-size: 15px !important;
    }

</style>
