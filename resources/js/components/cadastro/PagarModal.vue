<template>
    <b-modal id="pagar" size="xl">
        <template #modal-header="{ close }">
            <div class="text-center">
                <h1>Escolha uma forma de Pagamento</h1>
            </div>
            <b-button size="sm" variant="outline-danger" @click="close()">x</b-button>
        </template>
        <template>
            <div>
                <b-card no-body>
                <b-tabs card>
                    <b-tab title="Cartão de Crédito" active>
                    <b-card-text>
						<div class="container">
							<div class="section-head style-3 text-center z mb-3">
								<h2 class="title">Checkout <img :src="url+'/images/pagseguro.png'"></h2>
								<p>Preencha os dados para finalizar o pagamento</p>
							</div>
						</div>

                        <div class="container">
                            <b-row>
                                <b-col cols="12" sm="6" lg="6">
                                    <b-form-group label="Número do Cartão" label-class="font-weight-bold">
                                        <b-form-input
                                            name="numCartao"
                                            size="sm"
                                            v-model="form.numCartao"
                                            @change="validarBanderia()"
                                            type="text"
                                            :disabled="loading"
                                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`numCartao`)}]"
                                            v-validate="{ required: true }"
                                            aria-describedby="input-1-live-feedback"
                                            data-vv-as="Número do Cartão"
                                            v-mask="'#### #### #### ####'"
                                        ></b-form-input>
                                        <span v-show="errors.has(`numCartao`)" class="invalid-feedback">
                                            {{ errors.first(`numCartao`) }}
                                        </span>
                                        <div class="container" style="display:none !important">
                                            <div class="row">
                                                <span class="col-6 input-group-text bandeira-cartao creditCard hidden" id="cartao-bandeira" style="background-color: #ffffff;"></span>
                                                <span type="text" class="col-6 input-group-text cartao-nome creditCard form-login-help hidden" id="cartao-nome" style="background-color: #ffffff;"></span>
                                            </div>
                                        </div>
                                    </b-form-group>
                                </b-col>

                                <b-col cols="12" sm="6" lg="6">
                                    <b-form-group label="Validade" label-class="font-weight-bold">
                                        <b-form-input
                                            name="validade"
                                            size="sm"
                                            v-model="form.validade"
                                            type="text"
                                            :disabled="loading"
                                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`validade`)}]"
                                            v-validate="{ required: true }"
                                            aria-describedby="input-1-live-feedback"
                                            data-vv-as="Validade"
                                            v-mask="'##-####'"
                                        ></b-form-input>
                                        <span v-show="errors.has(`validade`)" class="invalid-feedback">
                                            {{ errors.first(`validade`) }}
                                        </span>
                                    </b-form-group>
                                </b-col>

                                <b-col cols="12" sm="6" lg="6">
                                    <b-form-group label="Código de Segurança" label-class="font-weight-bold">
                                        <b-form-input
                                            name="cvv"
                                            size="sm"
                                            v-model="form.cvv"
                                            type="text"
                                            :disabled="loading"
                                            :class="['form-control form-control-sm', {'is-invalid': errors.has(`cvv`)}]"
                                            v-validate="{ required: true }"
                                            aria-describedby="input-1-live-feedback"
                                            data-vv-as="Código de Segurança"
                                            v-mask="'####'"
                                        ></b-form-input>
                                        <span v-show="errors.has(`cvv`)" class="invalid-feedback">
                                            {{ errors.first(`cvv`) }}
                                        </span>
                                    </b-form-group>
                                </b-col>

                                <b-col>
                                    <div class="form-group" style="display:none !important">
                                        <label for="qntParcelas" class="col-sm-3 control-label">Quantidade de Parcelas</label>
                                        <div class="col-sm-5 creditCard">                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>				                                            
                                                <select class="form-control" id="qntParcelas" name="qntParcelas" oninput="this.className = 'form-control'" required>                                        
                                                </select>
                                            </div>
                                        </div>	
                                    </div>
                                </b-col>

                            </b-row>
					        <div class="meio-pag-credito" id="meio-pag-credito" name="meio-pag-credito" align="center" style="padding-top:10px; padding-bottom: 20px" />
                        </div>
                    </b-card-text>
                    </b-tab>
                    <b-tab title="Boleto">
                    <b-card-text>Tab contents 2</b-card-text>
                    </b-tab>
                </b-tabs>
                </b-card>
            </div>
        </template>

        <template #modal-footer="{ cancel }">
            <b-button
                size="md"
                variant="outline-danger"
                @click="cancel()"
                :disabled="loading"
            >
                Cancelar
            </b-button>
            <b-button
                :disabled="loading"
                size="md"
                variant="outline-success"
                @click="save()"
            >
                {{ hasCredito == true ? "Crédito" : "Boleto" }}
            </b-button>
        </template>
    </b-modal>
</template>

<script>
  import MixinsGlobal from  '../mixins/global-mixins'

    export default {
        props: ['selectedPagar', 'id'],
        mixins: [ MixinsGlobal],
        data() {
            return {            
                loading: false,
                url: process.env.MIX_BASE_URL,
                script_pagseguro: null,
                sessions_pagseguro: null,
                amount: "0.20",
                form: {
                    metodo: null,
                    numCartao: null,
                    validade: null,
                    cvv: null,
                    bandeira: null,
                }
            }
        },
        watch: {
            selectedPagar(){
                if(this.selectedPagar){
                    this.form.metodo = "credito"
                    this.form._method = "post"
                    this.form.id = this.selectedPagar.id
                    this.form.name = this.selectedPagar.name
                    this.form.email = this.selectedPagar.email
                    this.form.password = this.selectedPagar.password
                    this.form.cpf = this.selectedPagar.cpf
                    this.form.rg = this.selectedPagar.rg
                    this.form.orgao_expedidor = this.selectedPagar.orgao_expedidor
                    this.form.estrangeiro = this.selectedPagar.estrangeiro
                    this.form.passaporte = this.selectedPagar.passaporte
                    this.form.data_nascimento = this.selectedPagar.data_nascimento
                    this.form.sexo_id = this.selectedPagar.sexo_id
                    this.form.celular = this.selectedPagar.celular
                    this.form.telefones = this.selectedPagar.telefones
                    this.form.enderecos = this.selectedPagar.enderecos
                    this.form.instituicao_id = this.selectedPagar.instituicao_id
                    this.form.titulacao_id = this.selectedPagar.titulacao_id
                    this.form.associado = this.selectedPagar.associado
                    this.form.ativo = this.selectedPagar.ativo
                }
            },
            numCartao(){
                if(this.form.numCartao){
                   validarBanderia()
                }
            }
        },
        computed:{
            hasCredito(){
                return this.form.numCartao != null ? true : false;
            }
        },
        methods: {
            async pagamento(){
                await axios.get(`${process.env.MIX_BASE_URL}/pagseguro/pagamento`).then(res => {
                this.sessions_pagseguro = res.data

                PagSeguroDirectPayment.setSessionId(res.id);

                })
                this.listarMeiosPag()
            },
            async listarMeiosPag(){
                PagSeguroDirectPayment.getPaymentMethods({
                        amount: this.amount,
                        success: function (retorno) {            
                            //Recuperar as bandeiras do cartão de crédito
                            $.each(retorno.paymentMethods.CREDIT_CARD.options, function (i, obj) {
                                $('.meio-pag-credito').append("<span class='img-band'><img src='https://stc.pagseguro.uol.com.br" + obj.images.MEDIUM.path + "'></span>");
                            });
                        },
                        error: function (retorno) {
                            // Callback para chamadas que falharam.
                        },
                        complete: function (retorno) {
                            // Callback para todas chamadas.
                            //recupTokemCartao();
                        }
                    });
            },
            validarBanderia(){
                var numCartao = this.form.numCartao;
                var validou = true;
                numCartao = numCartao.replace(/\-/g, '');
                                

                PagSeguroDirectPayment.getBrand({
                    cardBin: numCartao,
                    success: function (retorno) {
                        console.log(retorno);
                        //Enviar para o index a imagem da bandeira
                        var imgBand = retorno.brand.name;
                        $('.bandeira-cartao').html("<img src='https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/" + imgBand + ".png'>");
                        $('.cartao-nome').html(imgBand);
                        
                        $('#cartao-bandeira').removeClass('hidden');
                        $('.cartao-nome').removeClass('hidden');
                                                    
                        validou = true;
                        recupParcelas(imgBand);
                        this.loading = false;
                    },
                    error: function (retorno) {
                        validou = false;
                    }
                });
                
            },
            recupParcelas(){
                var noIntInstalQuantity = $('#noIntInstalQuantity').val();
                PagSeguroDirectPayment.getInstallments({
                    
                    amount: amount,
                    maxInstallmentNoInterest: noIntInstalQuantity,

                    //Tipo da bandeira
                    brand: bandeira,
                    success: function (retorno) {
                        $.each(retorno.installments, function (ia, obja) {
                            $.each(obja, function (ib, objb) {

                                //Converter o preço para o formato real com JavaScript
                                var valorParcela = objb.installmentAmount.toFixed(2).replace(".", ",");

                                //Acrecentar duas casas decimais apos o ponto
                                var valorParcelaDouble = objb.installmentAmount.toFixed(2);
                                //Apresentar quantidade de parcelas e o valor das parcelas para o usuário no campo SELECT
                                $('#qntParcelas').show().append("<option value='" + objb.quantity + "' data-parcelas='" + valorParcelaDouble + "'>" + objb.quantity + " parcelas de R$ " + valorParcela + "</option>");
                            });
                        });
                    },
                    error: function (retorno) {
                        // callback para chamadas que falharam.
                    },
                    complete: function (retorno) {
                        // Callback para todas chamadas.
                    }
                });

            },
            async save() {
                this.loading = true
                await this.$validator.validateAll().then((valid) => {
                    if(valid) {
                        this.message('Aguarde...', 'Estamos salvando suas informações', 'info', -1);

                        setTimeout(() => {
                            axios.post(`${process.env.MIX_BASE_URL}/pagseguro/associado/credito`, this.form).then( res => {

                                this.message('Sucesso', res.status == 201 ? 'Usuário cadastrado.' : 'Usuário atualizado.', 'success');
                                
                                    window.location.href = `${process.env.MIX_BASE_URL}/login?status=2`
                               
                            }).catch(error => {
                                if(error.response.status == 422) {
                                    if(error.response.data.message == "The given data was invalid.") {
                                        this.loading = false
                                        return this.message('Campos Obrigatórios', 'Preencha todos os campos obrigatórios', 'error');
                                    }
                                }
                                if(error.response.status == 500) {
                                    this.loading = false
                                    this.message('Erro', 'Por favor tente novamente.', 'error');
                                }
                                if(error.response.status == 403) {
                                    if(error.response.data.message == "This action is unauthorized.") {
                                        this.loading = false
                                        this.message('Erro', 'Ação não autorizada.', 'error');
                                    }
                                }
                            })
                        },1000)
                    } else {
                        this.loading = false
                        this.message('Campos Obrigatórios', 'Preencha todos os campos obrigatórios', 'error');
                    }
                })
            },


        },
        created() {
            this.pagamento()
        },

    }

</script>


<style scoped>
    ::v-deep .modal-backdrop {
        opacity: 0.5 !important;
    }
</style>