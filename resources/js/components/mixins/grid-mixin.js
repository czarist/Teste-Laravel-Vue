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
            regiao_search: null,
            modalidade_search: 0,
            categoria_search: 0,
            produto_search: 0,
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
                url = this.searchType ? url.concat(`&type=${this.searchType.link}`) : url
                url = this.startDate ? url.concat(`&start=${this.startDate}`) : url
                url = this.endDate ? url.concat(`&end=${this.endDate}`) : url
                url = this.sort ? url.concat(`&sort=${this.sort}`) : url
                url = this.regiao_search ? url.concat(`&regiao=${this.regiao_search}`) : url
                url = this.modalidade_search ? url.concat(`&modalidade=${this.modalidade_search}`) : url
                url = this.categoria_search ? url.concat(`&categoria=${this.categoria_search}`) : url
                url = this.produto_search ? url.concat(`&produto=${this.produto_search}`) : url
            return url
        }
    },

    methods: {
        async get(){

            $.ajax({
                method: "GET",
                url: `${this.url}`,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: 'json',
                success: (res) => {
                    this.$refs['scroll'].scrollTop = 0
                    this.registros = res.data
                    this.currentPage = res.current_page
                    this.totalPages = res.last_page
                    this.total = res.total
    
                    this.loading = false
                },
                error: (res) => {
                    console.log(res) 
                }
            }); 

        },

        nextPage(url){

            $.ajax({
                method: "GET",
                url: `${url}`,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: 'json',
                success: (res) => {
                    const toFilter = [...this.registros, ...res.data]
                    const filtered = toFilter.reduce((items, current) => {
                        const x = items.find(item => item.id === current.id);
                        return !x ? items.concat([current]) : items
                    }, []);
                    this.registros = filtered
                    this.currentPage = res.current_page
                    },
                error: (res) => {
                    console.log(res) 
                }
            }); 

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

            await $.ajax({
                method: "GET",
                url: `${process.env.MIX_BASE_URL}/get/userlogado`,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: 'json',
                success: (res) => {
                    this.user = res
                    this.gettingUser = false
                },
                error: (res) => {
                    console.log(res) 
                }
            }); 
        },

        removeReadonly(id) {
            document.getElementById(id).removeAttribute("readonly");
        },
    }
}
