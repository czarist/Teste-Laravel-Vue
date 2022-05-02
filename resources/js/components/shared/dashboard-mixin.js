
export default {
    props: ['filters'],
    data() {
        return {
            currentPage: null,
            lastPage:null,
            height: 260,
        }
    },
    watch: {
        filters: {
            deep: true,
            handler() {
                return this.get()
            }
        }
    },
    computed: {
        computeHeight: {
            get() {
                return this.height
            },
            set(value) {
                this.chartOptions = {...this.chartOptions, ...{
                    chart: {
                        height: value,
                    }
                }}
                this.height = value
            },
        }
    },
    methods: {
        expand(chart) {
            if(this.mdSize < 12) {
                this.mdSize++
                localStorage.setItem('md'+chart, this.mdSize);
            }
            if(this.xlSize < 12) {
                this.xlSize++
                localStorage.setItem('xl'+chart, this.xlSize);
            }
        },
        compress(chart) {
            if(this.mdSize > 4) {
                this.mdSize--
                localStorage.setItem('md'+chart, this.mdSize);
            }
            if(this.xlSize > 3) {
                this.xlSize--
                localStorage.setItem('xl'+chart, this.xlSize);
            }
        }
    },
}
