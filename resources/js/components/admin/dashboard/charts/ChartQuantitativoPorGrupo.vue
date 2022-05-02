<template>
    <div :class="`col-12 col-md-${mdSize} col-xl-${xlSize} text-center my-1`">
        <div class="card">
            <div class="card-body">
                <div v-show="loading">
                    <div class="progress">
                        <div
                            class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                            role="progressbar"
                            style="width: 100%; height:50px;"
                        ></div>
                    </div>
                </div>
                <div v-show="!loading">
                    <input
                        type="range"
                        v-model="computeHeight"
                        min="260"
                        :max="500"
                        class="form-control-range mb-2"
                    />
                    <vue-apex-charts :options="chartOptions" :series="series"></vue-apex-charts>
                    <div class="d-flex justify-content-between pages mb-n2">
                        <div class="d-flex flex-fill">
                            <div class="input-group input-group-sm col-12 ml-n3 mt-n1" v-if="categories">
                                <div class="input-group-prepend">
                                    <span class="btn btn-primary">
                                        <i class="fas fa-at"></i>
                                    </span>
                                </div>
                                <select class="form-control" @change="changeCat($event)">
                                    <option v-for="(category, i) in categories" :key="i" :value="i" >{{ category | capitalizeFirstLetter }}</option>
                                </select>
                            </div>
                        </div>
                        <span>Página: {{ currentPage }} de {{ lastPage }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import debounce from 'debounce'
    import VueApexCharts from 'vue-apexcharts'
    import ptBR from '../../../../dicionario/apexchart/pt-br.json'
    import DashboardMixin from '../../../shared/dashboard-mixin'
    export default {
        props: {
            endpoint: {
                required: true
            },
            grupo: {
                required: true
            },
            color: {
                required: true
            },
            titulo: {
                required: true
            },
            categories: {
                type: Array,
                default: null
            }
        },
        components: {
            VueApexCharts,
        },
        mixins: [DashboardMixin],
        data() {
            return {
                mdSize: localStorage.getItem(`mdQuantitativoGrupo${this.endpoint}`) ? localStorage.getItem(`mdQuantitativoGrupo${this.endpoint}`) : 12,
                xlSize:  localStorage.getItem(`xlQuantitativoGrupo${this.endpoint}`) ? localStorage.getItem(`xlQuantitativoGrupo${this.endpoint}`) : 4,
                loading: true,
                series: [{
                    name: this.titulo,
                    data: []
                }],
                chartOptions: {
                    colors: [this.color],
                    title: {
                        text: `Quantidade de ${this.titulo}`,
                        align: 'left',
                        margin: 10,
                        offsetX: 0,
                        offsetY: 20,
                        floating: false,
                        style: {
                            fontSize:  '14px',
                            fontWeight:  'bold',
                            color:  '#263238'
                        },
                    },
                    chart: {
                        events: {
                            dataPointSelection: (event, chartContext, config) => {
                                this.$emit('clickChart', config.w.config.xaxis.categories[config.dataPointIndex])
                            }
                        },
                        defaultLocale: 'pt-br',
                        locales: [ptBR],
                        type: 'bar',
                        toolbar: {
                            tools: {
                                customIcons: [
                                    {
                                        icon: '<img src="'+process.env.MIX_BASE_URL+'/img/dashboard/arrow-alt-circle-left.png" width="20">',
                                        title: 'Página Anterior',
                                        class: 'custom-icon',
                                        click: (chart, options, e) => {
                                            if(this.currentPage > 1) {
                                                this.get(this.url.concat(`?page=${this.currentPage-1}`))
                                            }
                                        }
                                    },
                                    {
                                        icon: '<img src="'+process.env.MIX_BASE_URL+'/img/dashboard/arrow-alt-circle-right.png" width="20">',
                                        title: 'Próxima Página',
                                        class: 'custom-icon',
                                        click: (chart, options, e) => {
                                            if(this.currentPage < this.lastPage) {
                                                this.get(this.url.concat(`?page=${this.currentPage+1}`))
                                            }
                                        }
                                    },
                                    {
                                        icon: '<img src="'+process.env.MIX_BASE_URL+'/img/dashboard/tag-solid.png" width="20">',
                                        title: 'Labels ON/OFF',
                                        class: 'custom-icon',
                                        click: (chart, options, e) => {
                                            chart.updateOptions({
                                                dataLabels: {
                                                    enabled: !options.config.dataLabels.enabled
                                                }
                                            })
                                        }
                                    },{
                                        icon: '<img src="'+process.env.MIX_BASE_URL+'/img/dashboard/compress-alt-solid.png" width="15">',
                                        title: 'Retrair Gráfico',
                                        class: 'custom-icon',
                                        click: (chart, options, e) => {
                                            this.compress(`QuantitativoGrupo${this.endpoint}`)
                                        }
                                    },{
                                        icon: '<img src="'+process.env.MIX_BASE_URL+'/img/dashboard/expand-alt-solid.png" width="15">',
                                        title: 'Expandir Gráfico',
                                        class: 'custom-icon',
                                        click: (chart, options, e) => {
                                            this.expand(`QuantitativoGrupo${this.endpoint}`)
                                        }
                                    }
                                ],
                            },
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            columnWidth: '70%',
                            barHeight: '75%',
                            dataLabels: {
                                position: 'top'
                            }
                        }
                    },
                    dataLabels: {
                        style: {
                            colors: [this.color]
                        },
                        background: {
                            enabled: true,
                            foreColor: '#fff',
                            padding: 4,
                            borderRadius: 2,
                            borderWidth: 1,
                            borderColor: '#fff',
                            opacity: 0.9,
                            dropShadow: {
                                enabled: false,
                                top: 1,
                                left: 1,
                                blur: 1,
                                color: '#000',
                                opacity: 0.45
                            }
                        },
                    },
                    tooltip: {
                        y: {
                            formatter: val => `${val} ${this.titulo}`
                        }
                    }
                },
            }
        },
        watch: {
            endpoint: {
                deep: true,
                handler() {
                    this.get()
                }

            }
        },
        computed:{
            url() {
                return `${process.env.MIX_BASE_URL}/${this.endpoint}`
            }
        },
        methods: {
            async get(url = this.url) {
                this.series = [{
                    name: this.titulo,
                    data: []
                }]
                await axios.post(url, this.filters).then(res => {
                    console.log(res.data)
                    res.data.data.forEach(value => {
                        this.series[0].data.push(value.contagem)
                    })

                    this.chartOptions = {...this.chartOptions,
                        subtitle: {
                            text: `Por ${this.grupo}`,
                            align: 'left',
                            margin: 10,
                            offsetX: 0,
                            offsetY: 40,
                            style: {
                                fontSize:  '12px',
                                fontWeight:  'normal',
                                color:  '#9699a2'
                            },
                        },
                        chart: {
                            height: this.height,
                        },
                        xaxis: {
                            categories: res.data.data.map(value => {
                                switch (this.grupo) {
                                    case 'inscritos':
                                        return `${value.descricao}`
                                        break;
                                    case 'inscritos_pagos':
                                        return `${value.descricao}`
                                        break;
                                    case 'submissao_expocom':
                                        return `${value.descricao}`
                                        break;
                                    case 'submissao_dt':
                                        return `${value.descricao}`
                                        break;
                                    case 'submissao_ij':
                                        return `${value.descricao}`
                                        break;
                                    case 'submissao_mesa':
                                        return `${value.descricao}`
                                        break;
                                    case 'inscritos_isentos':
                                        return `${value.descricao}`
                                        break; 
                                    case 'associados_inscritos':
                                        return `${value.descricao}`
                                        break;                                    
                                    default:
                                        console.log("Grupo invalido.");
                                        break;
                                }
                            })
                        },
                        yaxis: {
                            labels: {
                                show: true,
                                align: 'right',
                                minWidth: 0,
                                maxWidth: 500
                            },
                            title: {
                                style: {
                                    fontSize: '13px',
                                    fontWeight: 600,
                                },
                            },
                        },
                    }
                }).then(() => {
                    this.loading = false
                })
            },
            changeCat(event) {
                this.$emit('changeCat', event.target.value)
            }
        },
        created () {
            this.get = debounce(this.get, 600)
            this.get()
        },
    }
</script>

