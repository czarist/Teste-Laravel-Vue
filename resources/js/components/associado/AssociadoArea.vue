<template>
    <div class="mt-4">
        <h5 class="col-12 d-flex justify-content-between">
            Associados
        </h5>
        <div class="col-12">
            <div class="card">
                <div class="card-body pb-2">
                   
                    <div class="table-responsive scroll" ref="scroll" >
                        <table class="table table-sm table-striped table-hover table-bordered" >
                            <thead>
                                <tr>
                                    <th class="align-middle text-center" width="20%">NOME</th>
                                    <th class="align-middle text-center" width="10%">CPF</th>
                                    <th class="align-middle text-center" width="10%">VALOR</th>
                                    <th class="align-middle text-center" width="10%">AÇÃO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr >
                                    <td class="align-middle text-center">{{ user ? user.name : "NI" }}</td>
                                    <td class="align-middle text-center">{{ user ? user.cpf : "NI" }}</td>
                                    <td class="align-middle text-center">R$230,00</td>
                                    <td class="align-middle text-center">
                                        <span class="d-flex justify-content-center">
                                            <a
                                                v-if="!user.is_associado"
                                                class="btn btn-outline-alert mr-1"
                                                :href="baseUrl+'/filiese'"
                                            >FILIAR-SE</a>

                                            <span
                                                v-if="user.is_associado"
                                               class="btn btn-outline-danger btn-sm"
                                              @click="pagar()"
                                            >PAGAR ANUIDADE 2022</span>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="alert alert-danger" role="alert" v-if="!loading && post.length == 0">
                        <h4 class="alert-heading">Ops!</h4>
                        Nenhum encontrado.
                    </div>
                </div>
            </div>
        </div>
        <pagar-modal :selectedPagar="selectedPagar"></pagar-modal>
        <notifications group="submit" position="center bottom" />
    </div>
</template>

<script>
    import debounce from 'debounce'
    import moment from 'moment'
    import MixinsGlobal from  '../mixins/global-mixins'

    export default {
        props: ['user'],
        mixins: [ MixinsGlobal],
        components: {
            'pagar-modal': () => import('./PagarModal'),
        },
        data() {
            return {
                loading: false,
                baseUrl: process.env.MIX_BASE_URL,
                selcetedUser: this.user,
                selectedPagar: this.user,
                script_pagseguro: null,
                sessions_pagseguro: null,
                generos: [],
                estados: [],
                municipios: [],
                generos: [],
                instituicoes: [],
                paises: [],
                titulacoes: [],
                post: {
                    id: null,
                    name: null,
                    email: null,
                    password: null,
                    estrangeiro: 0,
                    anuidade2022: 1,
                    associacao: null,
                    data_nascimento: null,
                    orgao_expedidor: null,    
                    instituicao_id: null,    
                    titulacao_id: null,            
                    cpf: null,
                    rg:null,
                    telefone: null,
                    celular: null,
                    sexo_id: null,
                    ativo: 1,
                    acessos: [],
                    enderecos: {
                        id: null,
                        cep: null,
                        logradouro: null,
                        bairro: null, 
                        municipio: null,
                        estado: null,
                        pais: null,
                    },
                    _method: 'post'
                },

            }
        },
        watch: {
            selcetedUser(){
                console.log('watch user')
                if(this.selcetedUser){
                    debounce(this.getEstados(), 1000)
                    this.post.metodo = "credito"
                    this.post._method = "post"
                    this.post.id = this.selcetedUser.id ? this.selcetedUser.id : null
                    this.post.name = this.selcetedUser.name ? this.selcetedUser.name : null
                    this.post.email = this.selcetedUser.email ? this.selcetedUser.email : null 
                    this.post.password = this.selcetedUser.password ? this.selcetedUser.password : null
                    this.post.cpf = this.selcetedUser.cpf ? this.selcetedUser.cpf : null
                    this.post.rg = this.selcetedUser.rg ? this.selcetedUser.rg : null
                    this.post.orgao_expedidor = this.selcetedUser.orgao_expedidor ? this.selcetedUser.orgao_expedidor : null
                    this.post.estrangeiro = this.selcetedUser.estrangeiro ? 1 : 0
                    this.post.passaporte = this.selcetedUser.passaporte ? this.selcetedUser.passaporte : null
                    this.post.data_nascimento = this.selcetedUser.data_nascimento ? this.selcetedUser.data_nascimento : null
                    this.post.sexo_id = this.selcetedUser.sexo_id ? this.selcetedUser.sexo_id : null
                    this.post.celular = this.selcetedUser.celular ? this.selcetedUser.celular : null
                    this.post.telefone = this.selcetedUser.telefone ? this.selcetedUser.telefone : null
                    this.post.instituicao_id = this.selcetedUser && this.selcetedUser.associado ? this.selcetedUser.associado.instituicao_id : null
                    this.post.titulacao_id = this.selcetedUser && this.selcetedUser.associado ? this.selcetedUser.associado.titulacao_id : null
                    this.post.ativo = this.selcetedUser.ativo ? this.selcetedUser.ativo : null,
                    this.post.associacao = this.selcetedUser.associado ? this.selcetedUser.associado.associacao : null,
                    this.post.enderecos = {
                        id: this.selcetedUser && this.selcetedUser.enderecos[0].id ? this.selcetedUser.enderecos[0].id : null,
                        cep: this.selcetedUser && this.selcetedUser.enderecos[0].cep ? this.selcetedUser.enderecos[0].cep : null,
                        logradouro: this.selcetedUser && this.selcetedUser.enderecos[0].logradouro ? this.selcetedUser.enderecos[0].logradouro : null,
                        municipio: this.selcetedUser && this.selcetedUser.enderecos[0].municipio ? this.selcetedUser.enderecos[0].municipio : null,
                        estado: this.selcetedUser && this.selcetedUser.enderecos[0].municipio.estado ? this.selcetedUser.enderecos[0].municipio.estado.id : null,
                        pais: this.selcetedUser && this.selcetedUser.enderecos[0].pais_id ? this.selcetedUser.enderecos[0].pais_id : null,
                    }
                }
            }
        },
        methods: {
            pagar() {
                this.selectedPagar = this.user
                $('#pagar').modal({keyboard: false, show: true})
                this.$bvModal.show('pagar')
            },
            async pagamento(){
                await axios.get(`${process.env.MIX_BASE_URL}/pagseguro/pagamento`).then(res => {
                this.sessions_pagseguro = res.data
                PagSeguroDirectPayment.setSessionId(this.sessions_pagseguro.id);
                })
            },
            async getEstados(){
                await axios.get(`${process.env.MIX_BASE_URL}/get/estados`).then( res => {
                    this.estados = res.data
                })
            },
            async getMunicipios() {
                if(this.post.enderecos && this.post.enderecos.estado) {
                    await axios.get(`${process.env.MIX_BASE_URL}/get/municipios/${this.post.enderecos.estado.id}`).then(res => {
                        this.municipios =  res.data
                    }).then(() => {
                        if(this.selected && this.selected.enderecos) {
                            this.post.enderecos.municipio = this.municipios.find(municipio => municipio.nome == this.selected.enderecos.municipio.nome)
                            this.$validator.reset(`municipio${i}`)
                        }
                    })
                }
            },
            async getCep() {
                if(this.post.enderecos.cep.length > 8) {
                    await fetch(`https://viacep.com.br/ws/${this.post.enderecos.cep}/json`).then(res => res.json())
                        .then(res => {
                            this.post.enderecos = {
                                cep: this.post.enderecos.cep,
                                logradouro: res.logradouro,
                                bairro: res.bairro,
                                estado: this.estados.find(uf => uf.sigla == res.uf),
                                municipio: null,
                                id: this.post.enderecos.id,
                                numero: this.post.enderecos.numero,
                                complemento: null,
                                deleted: false

                            }
                            this.location = res.localidade

                            if(res.erro == true) {
                                this.$notify({
                                    group: "submit",
                                    title: "Erro",
                                    text: 'Endereço não encontrado!, tente novamente.',
                                    type: "error"
                                })
                                this.loading = false
                            }
                        })
                      
                    await this.getMunicipios()
                        this.post.enderecos.municipio = this.municipios.find(municipio => municipio.nome == this.location)
                        this.$forceUpdate()                

                }
            },

        },
        async created() {
            this.pagamento()

            axios.get(process.env.MIX_BASE_URL+'/get/tiposexo').then(res => {
               
                this.generos = res.data
            })

            axios.get(`${process.env.MIX_BASE_URL}/get/instituicoes`).then(res => {
                this.instituicoes = res.data;
            })

            axios.get(`${process.env.MIX_BASE_URL}/get/titulacoes`).then(res => {
                this.titulacoes = res.data;
            })
          
            this.getEstados()
        },
        mounted() {
        },
        destroyed () {
        },
    }
</script>
