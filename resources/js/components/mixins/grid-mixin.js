export default {
    data() {
        return {
            searchType: null,
            loading: false,
            startDate: null,
            endDate: null,
            status: 0,
            statuses: [],
            search: null,
            sort: null,
            registros: [],
            sort: 'id',
            asc: false,
            currentPage: null,
            totalPages: null,
            total: null,
            trashed: false,
            gettingUser: false,
            user: null,
        }
    },
    watch: {
        searchType: {
            deep: true,
            handler() {
                if(this.search) {
                    return this.get()
                }
            }
        },

        trashed() {
            return this.get()
        }
    },

    computed: {
        url() {
            let url = `${process.env.MIX_BASE_URL}/${this.page}/get?trashed=${this.trashed}&status=${this.status}&asc=${this.asc}`
                url = this.search ? url.concat(`&search=${this.search}`) : url
                url = this.status ? url.concat(`&status=${this.status}`) : url
                url = this.searchType ? url.concat(`&type=${this.searchType.link}`) : url
                url = this.startDate ? url.concat(`&start=${this.startDate}`) : url
                url = this.endDate ? url.concat(`&end=${this.endDate}`) : url
                url = this.sort ? url.concat(`&sort=${this.sort}`) : url
            return url
        }
    },

    methods: {
        async get(){
            await axios.get(this.url).then(res => {
                this.$refs['scroll'].scrollTop = 0
                this.registros = res.data.data
                this.currentPage = res.data.current_page
                this.totalPages = res.data.last_page
                this.total = res.data.total
                this.documentos = res.data[1]

                this.loading = false
            })
        },

        nextPage(url){
            axios.get(url).then(res => {
                const toFilter = [...this.registros, ...res.data.data]
                const filtered = toFilter.reduce((items, current) => {
                    const x = items.find(item => item.id === current.id);
                    return !x ? items.concat([current]) : items
                }, []);
                this.registros = filtered
                this.currentPage = res.data.current_page
            })
        },

        handleScroll(event) {
            if(this.$refs['scroll'].scrollHeight - this.$refs['scroll'].scrollTop <= (this.$refs['scroll'].clientHeight + 700) && this.currentPage < this.totalPages) {
                let url = this.url.concat(`&page=${this.currentPage+1}`)
                this.nextPage(url);
            }
        },

        handleSort(field) {
            if(field == this.sort && this.asc == false) {
                this.sort = 'id'
            } else {
                this.sort = field
                this.asc = !this.asc
            }
            this.get()
        },

        cancel(url) {
            window.location.href = process.env.MIX_BASE_URL+url
        },

        async getLoggedUser() {
            this.gettingUser = true
            await axios.get(`${process.env.MIX_BASE_URL}/get/userlogado`).then(res => {
                this.user = res.data
                this.gettingUser = false
            })
        },

        removeReadonly(id) {
            document.getElementById(id).removeAttribute("readonly");
        },
    }
}
