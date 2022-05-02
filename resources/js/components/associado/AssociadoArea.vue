<template>
    <div class="mt-4">
        <h5 class="col-12 d-flex justify-content-between">
            Associados
        </h5>
        <div class="col-12" v-if="anuidade_paga == false">
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
                                <tr v-if="!user.is_associado">
                                    <td class="align-middle text-center">{{ user ? user.name : "NI" }}</td>
                                    <td class="align-middle text-center">{{ user ? user.cpf : "NI" }}</td>
                                    <td class="align-middle text-center">R$230,00</td>
                                    <td class="align-middle text-center">
                                        <span class="d-flex justify-content-center">
                                            <a                                                
                                                class="btn btn-outline-alert mr-1"
                                                :href="baseUrl+'/filiese'"
                                            >FILIE-SE
                                            </a>                                            
                                        </span>
                                    </td>
                                </tr>
                                <tr v-if="user.is_associado && !user.anuidade_2022">
                                    <td class="align-middle text-center">{{ user ? user.name : "NI" }}</td>
                                    <td class="align-middle text-center">{{ user ? user.cpf : "NI" }}</td>
                                    <td class="align-middle text-center">R$230,00</td>
                                    <td class="align-middle text-center">
                                        <span class="d-flex justify-content-center">
                                            <a                                                
                                                class="btn btn-outline-danger btn-sm mr-1"
                                                :href="baseUrl+'/anuidade'"
                                            >PAGAR ANUIDADE 2022
                                            </a>
                                            
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class='col-12 alert alert-success text-center mt-3 mb-3' role='alert' v-else>
            <h4 class='alert-heading'>Parabéns!</h4>
            <p><b>Sua Anuidade 2022 esta em dia!</b></p>
        </div>
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
                anuidade_paga: this.user && this.user.anuidade_2022 ? this.user.anuidade_2022 : false,

            }
        },
    }
</script>
