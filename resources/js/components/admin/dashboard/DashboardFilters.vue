<template>
    <div class="col-12 mb-2">
        <div class="row">
            <b-col cols="12" sm="6" lg="6">
                <b-form-group label="Pesquisar por tipo" label-class="font-weight-bold" >
                    <b-form-select
                        name="tipo"
                        :class="['form-control form-control-sm']"
                        size="sm"
                        data-vv-as="Regiao"
                        @input="emit"
                    v-model="filter.tipo"
                    >
                    <option :value="null">Selecione...</option>
                    <option v-for="regiao in regioes" :value="regiao.value" :key="regiao.value">
                        {{ regiao.text }}
                    </option>
                    </b-form-select>

                </b-form-group>
            </b-col>

        </div>
    </div>
</template>

<script>
    import { ptBR } from 'vuejs-datepicker/dist/locale'
    import Datepicker from 'vuejs-datepicker';
    export default {
        props: ['filters'],
        components: {
            Datepicker,
        },
        data() {
            return {
                ptBR: ptBR,
                filter: {
                    tipo: null,
                },
                regioes: [
                    { text: 'Norte', value: "norte" },
                    { text: 'Nordeste', value: "nordeste" },
                    { text: 'Sul', value: 'sul' },
                    { text: 'Sudeste', value: "sudeste" },
                    { text: 'Centro Oeste', value: "centro_oeste" },
                    { text: 'Nacional', value: "nacional" },
                ],

            }
        },
        watch: {
            filters: {
                deep: true,
                handler() {
                    this.filter.tipo = this.filters.tipo
                }
            }
        },
        methods: {
            clear(field) {
                this.filter[field] = null
                this.emit()
            },
            emit() {
                if(this.filter.data_final && this.filter.data_inicial) {
                    let a = moment(this.filter.data_final)
                    let b = moment(this.filter.data_inicial)
                    if(a.diff(b, 'days') > 93) {
                        this.$notify({
                            group: "submit",
                            title: "Erro!",
                            text: "Periodo deve ser menor do que 3 meses.",
                            type: "error"
                        })
                        return false
                    } else {
                        this.$emit('filter', this.filter)
                    }
                } else {
                    this.$notify({
                        group: "submit",
                        title: "Erro!",
                        text: "Selecione um periodo.",
                        type: "error"
                    })
                }
            }
        },
        created() {
            this.filter.data_inicial = moment().subtract(3, 'months').format()
            this.filter.data_final = moment().format()
        }
    }
</script>

<style>

</style>
