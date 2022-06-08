<template>
    <div>
        <div class="col-12">
            <h5 class="page-header d-flex justify-content-between">
                Dashboard Intercom
            </h5>
        </div>

        <div class="row">
            <dashboard-filters
                @filter="filters = $event"
                :filters="filters"
            ></dashboard-filters>
            <div class="col-md-6 col-xl-6 col-12 mb-2 text-center">
                <div class="card">
                    <div class="card-body">
                        <span><b>Valor total pago</b></span>
                        <h5 class="mt-2"> {{ vlr_total_inscritos | formatPrice }} </h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-row">

                <quantitativo-por-grupo
                    titulo="Inscritos"
                    grupo="inscritos"
                    endpoint="dashboard/inscritos"
                    color="#38acbc"
                    :filters="filters"
                    @clickChart="filters.inscritos = $event.split(' (')[0]"
                ></quantitativo-por-grupo>

                <quantitativo-por-grupo
                    titulo="Inscritos Pagos"
                    grupo="inscritos_pagos"
                    endpoint="dashboard/inscritos_pagos"
                    color="#38acbc"
                    :filters="filters"
                    @clickChart="filters.inscritos_pagos = $event.split(' (')[0]"
                ></quantitativo-por-grupo>

                <quantitativo-por-grupo
                    titulo="Inscritos Isentos"
                    grupo="inscritos_isentos"
                    endpoint="dashboard/inscritos_isentos"
                    color="#38acbc"
                    :filters="filters"
                    @clickChart="filters.submissao_mesa = $event.split(' (')[0]"
                ></quantitativo-por-grupo>

                <quantitativo-por-grupo
                    titulo="Associados Inscritos Isentos"
                    grupo="associados_inscritos"
                    endpoint="dashboard/associados_inscritos"
                    color="#38acbc"
                    :filters="filters"
                    @clickChart="filters.submissao_mesa = $event.split(' (')[0]"
                ></quantitativo-por-grupo>

                <quantitativo-por-grupo
                    titulo="Submissão Expocom"
                    grupo="submissao_expocom"
                    endpoint="dashboard/submissao_expocom"
                    color="#38acbc"
                    :filters="filters"
                    @clickChart="filters.submissao_expocom = $event.split(' (')[0]"
                ></quantitativo-por-grupo>

                <quantitativo-por-grupo
                    titulo="Submissão DTs"
                    grupo="submissao_dt"
                    endpoint="dashboard/submissao_dt"
                    color="#38acbc"
                    :filters="filters"
                    @clickChart="filters.submissao_dt = $event.split(' (')[0]"
                ></quantitativo-por-grupo>

                <quantitativo-por-grupo
                    titulo="Submissão IJs"
                    grupo="submissao_ij"
                    endpoint="dashboard/submissao_ij"
                    color="#38acbc"
                    :filters="filters"
                    @clickChart="filters.submissao_ij = $event.split(' (')[0]"
                ></quantitativo-por-grupo>

                <quantitativo-por-grupo
                    titulo="Submissão Mesa"
                    grupo="submissao_mesa"
                    endpoint="dashboard/submissao_mesa"
                    color="#38acbc"
                    :filters="filters"
                    @clickChart="filters.submissao_mesa = $event.split(' (')[0]"
                ></quantitativo-por-grupo>
            </div>
        </div>
        <notifications group="submit" position="center bottom" />
    </div>
</template>

<script>
import { ptBR } from 'vuejs-datepicker/dist/locale'
import Datepicker from 'vuejs-datepicker';
export default {
    components: {
        Datepicker,
        DashboardFilters: () => import('./DashboardFilters'),
        QuantitativoPorGrupo: () => import('./charts/ChartQuantitativoPorGrupo'),
        // DashboardCards: () => import('./cards/DashboardCards'),
    },
    data() {
        return {
            moment: moment,
            ptBR: ptBR,
            filters: {
                data_inicial: null,
                data_final: null,
                tipo: null
            },
            vlr_total_inscritos: 0,
        }
    },
    watch: {
        filters: {
            deep: true,
            handler() {
                this.getValorTotal()
            }
        }
    },
    methods:{
        async getValorTotal(){
            await axios.post(`${process.env.MIX_BASE_URL}/dashboard/valor_total`, this.filters).then( res => {
                this.vlr_total_inscritos = res.data.data[0].vlr_total_inscritos
            })
        }
    },
    created() {
        this.filters.data_inicial = moment().subtract(3, 'months').format()
        this.filters.data_final = moment().format()
        this.getValorTotal()
    }
}
</script>
