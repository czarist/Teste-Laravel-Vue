<template>
    <b-modal id="pagar" size="xl">
        <template #modal-header="{ close }">
            <div class="text-center">
                <div align="center">
                <p style="font-size:18px !important; text-align:center !important;">Escolha uma forma de Pagamento testes Anuidade modal</p>
                </div>
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
                                                v-mask="'####-####-####-####'"
                                            ></b-form-input>
                                            <span v-show="errors.has(`numCartao`)" class="invalid-feedback">
                                                {{ errors.first(`numCartao`) }}
                                            </span>
                                            <div class="container hidden">
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
                                                v-mask="'##/####'"
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

                                    <b-col cols="12" sm="6" lg="6">
                                        <b-form-group label="Quantidade de Parcelas" label-class="font-weight-bold">
                                            <b-form-select
                                                :disabled="true"
                                                name="qntParcelas"
                                                id="qntParcelas"
                                                v-validate="{ required: true }"
                                                :class="['form-control form-control-sm', {'is-invalid': errors.has(`qntParcelas`)}]"
                                                size="sm"
                                                data-vv-as="Quantidade de Parcelas"
                                                class="form-control form-control-sm"
                                                v-model="form.qntParcelas"
                                            >
                                            </b-form-select>
                                            <span v-show="errors.has(`qntParcelas`)" class="invalid-feedback">
                                                {{ errors.first(`qntParcelas`) }}
                                            </span>
                                        </b-form-group>
                                    </b-col>


                                </b-row>
                                <div class="meio-pag-credito" id="meio-pag-credito" name="meio-pag-credito" align="center" style="padding-top:10px; padding-bottom: 20px" />
                                <div class="hidden">
                                    <form method="post" accept-charset="utf-8" name="formPagamentoCartaoCredito" id="formPagamentoCartaoCredito" action="">
                                        <input type="hidden" name="recupHashCartao" id="recupHashCartao" value="">
                                        <input type="hidden" name="anuidade2022" id="anuidade2022" :value="1">
                                        <input type="hidden" name="ativo" id="ativo" :value="form.ativo">
                                        <input type="hidden" name="cpf" id="cpf" :value="form.cpf">
                                        <input type="hidden" name="numCartao" id="numCartao" :value="form.numCartao">
                                        <input type="hidden" name="cvv" id="cvv" :value="form.cvv">
                                        <input type="hidden" name="validade" id="validade" :value="form.validade">
                                        <input type="hidden" name="id" id="id" :value="form.id">
                                        <input type="hidden" name="metodo" id="metodo" :value="form.metodo">
                                        <input type="hidden" name="name" id="name" :value="form.name">
                                    </form>
                                </div>
                            </div>
                        </b-card-text>
                        </b-tab>

                        <b-tab title="Boleto">
                            <b-card-text>
                                <form class="form-horizontal" action="" method="post" accept-charset="utf-8" name="formPagamentoBoleto" id="formPagamentoBoleto">
                                    <fieldset>
                                    <div class="meio-pag-boleto" align="center" style="padding-bottom: 20px"></div>
                                    </fieldset>			
                                </form>
                            </b-card-text>
                        </b-tab>
                    </b-tabs>
                </b-card>
            </div>
            <notifications group="submit" position="center" width="500px" />
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
                v-if="hasCredito"
                :disabled="loading"
                size="md"
                variant="outline-success"
                @click="pagarCredito()"
            >Pagar
            </b-button>

            <b-button
                v-else
                :disabled="loading"
                size="md"
                variant="outline-success"
                @click="pagarBoleto()"
            >Gerar Boleto
            </b-button>
        </template>
    </b-modal>
</template>

<script>
    import MixinsGlobal from  '../mixins/global-mixins'
    import debounce from 'debounce'

    export default {
        props: ['selectedPagar', 'id'],
        mixins: [ MixinsGlobal],
        data() {
            return {            
                loading: false,
                url: process.env.MIX_BASE_URL,
                amount: null,
                form: {
                    metodo : "credito",
                    _method : "post",
                    id : this.selectedPagar ? this.selectedPagar.id : null,
                    name : this.selectedPagar ? this.selectedPagar.name : null,
                    email : this.selectedPagar ? this.selectedPagar.email : null,
                    cpf : this.selectedPagar ? this.selectedPagar.cpf : null,
                    rg: this.selectedPagar ? this.selectedPagar.rg : null,
                    orgao_expedidor: this.selectedPagar ? this.selectedPagar.orgao_expedidor : null,
                    estrangeiro : this.selectedPagar ? this.selectedPagar.estrangeiro : null,
                    passaporte : this.selectedPagar ? this.selectedPagar.passaporte : null,
                    data_nascimento : this.selectedPagar ? this.selectedPagar.data_nascimento : null,
                    sexo_id : this.selectedPagar ? this.selectedPagar.sexo_id : null,
                    celular : this.selectedPagar ? this.selectedPagar.celular : null,
                    instituicao_id : this.selectedPagar ? this.selectedPagar.instituicao_id : null,
                    titulacao_id : this.selectedPagar ? this.selectedPagar.titulacao_id : null,
                    anuidade2022 : null,
                    ativo : this.selectedPagar ? this.selectedPagar.ativo: null,
                    quantidade: 1,
                    produto: null,

                },
            }
        },
        watch: {
            selectedPagar(){
                if(this.selectedPagar){
                    this.form.metodo = "credito"
                    this.form._method = "post"
                    this.form.anuidade2022 = 1
                    this.form.id = this.selectedPagar.id
                    this.form.name = this.selectedPagar.name
                    this.form.email = this.selectedPagar.email
                    this.form.cpf = this.selectedPagar.cpf
                    this.form.estrangeiro = this.selectedPagar.estrangeiro
                    this.form.passaporte = this.selectedPagar.passaporte
                    this.form.ativo = this.selectedPagar.ativo
                }
                if(this.form.anuidade2022 == 1){
                    this.amount = this.produtos.find(produto => produto.id == 1).valor
                    this.form.produto = this.produtos.find(produto => produto.id == 1)
                }

                this.listarMeiosPag()

            },
            numCartao(){
                if(this.form.numCartao){
                   validarBanderia()
                }
            },
        },
        computed:{
            hasCredito(){
                return this.form.numCartao != null ? true : false;
            }
        },
        methods: {
            async getProdutos(){
                await $.ajax({
                    method: "GET",
                    url: "get/produtos",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.produtos = res
                    },
                    error: (res) => {
                        console.log(res)
                    }
                }); 
            },
            async listarMeiosPag(){
                PagSeguroDirectPayment.getPaymentMethods({
                    amount: this.amount,
                    success: function (retorno) {            
                        //Recuperar as bandeiras do cartão de crédito
                        $.each(retorno.paymentMethods.CREDIT_CARD.options, function (i, obj) {
                            $('.meio-pag-credito').append("<span class='img-band'><img src='https://stc.pagseguro.uol.com.br" + obj.images.MEDIUM.path + "'></span>");
                        });

                        //Recuperar as bandeiras do boleto
			            $('.meio-pag-boleto').append("<span  class='img-band'><img width='150' height='80' src='https://stc.pagseguro.uol.com.br" + retorno.paymentMethods.BOLETO.options.BOLETO.images.MEDIUM.path + "'><span>");

                    },
                    error: function (retorno) {
                        
                        this.message('Erro', 'O Pagseguro pode estar com lentidão ou instabilidade, tente novamente em alguns minutos', 'error');

                    },
                    complete: function (retorno) {
                        // Callback para todas chamadas.
                        //recupTokemCartao();
                    }
                });
            },
            validarBanderia(){
                var numCartao = this.form.numCartao.substr(0, 7);
                numCartao = numCartao.replace(/\-/g, '');    

                PagSeguroDirectPayment.getBrand({
                    cardBin: numCartao,
                    success: function (retorno) {
                        //Enviar para o index a imagem da bandeira
                        var imgBand = retorno.brand.name;
                        $('.bandeira-cartao').html("<img src='https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/" + imgBand + ".png'>");
                        $('.cartao-nome').html(imgBand);

                        $('#cartao-bandeira').removeClass('hidden');
                        $('.cartao-nome').removeClass('hidden');
                        
                        
                        
                    },
                    error: function (retorno) {

                        this.message('Erro', 'O Pagseguro pode estar com lentidão ou instabilidade, tente novamente em alguns minutos', 'error');

                    }
                });
                let nameBand = document.getElementById("cartao-nome").innerText
                this.form.bandeira = nameBand;
                this.recupParcelas(nameBand);
                
            },
            recupParcelas(bandeira){
                var noIntInstalQuantity = $('#noIntInstalQuantity').val();
                PagSeguroDirectPayment.getInstallments({
                    
                    amount: this.amount,
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
                        this.message('Erro', 'O Pagseguro pode estar com lentidão ou instabilidade, tente novamente em alguns minutos', 'error');
                    },
                    complete: function (retorno) {
                        // Callback para todas chamadas.
                    }
                });

            },
            pagarCredito(){
                var cardnum = this.form.numCartao.replace(/\-/g, '');  // Número do cartão de crédito
                var cardname = document.getElementById("cartao-nome").innerText;  // Bandeira do cartão
                var cardval = this.form.validade.split("/"); // Validade do cartão mes e ano.
                var cardmes = cardval[0];  // Mês da expiração do cartão
                var cardano = cardval[1];  // Ano da expiração do cartão, é necessário os 4 dígitos.
                var cardcvv = this.form.cvv;  // CVV do cartão

                PagSeguroDirectPayment.createCardToken({
                    cardNumber: cardnum,
                    brand: cardname,
                    cvv: cardcvv,
                    expirationMonth: cardmes,
                    expirationYear: cardano,
                    success: function (retorno) {
                        recupHashCartao(retorno.card.token);
                    },
                    error: function (retorno) {

                        this.message('Erro', 'O Pagseguro pode estar com lentidão ou instabilidade, tente novamente em alguns minutos', 'error');

                    },
                    complete: function (retorno) {
                        // Callback para todas chamadas.                
                    }
                });		

                function recupHashCartao(tokenCartao) {
                    PagSeguroDirectPayment.onSenderHashReady(function (retorno) {
                        if (retorno.status == 'error') {
                            console.log(retorno.message);
                            this.message('Erro', 'O Pagseguro pode estar com lentidão ou instabilidade, tente novamente em alguns minutos', 'error');

                            return false;
                        } else {
                            var hashCartao = retorno.senderHash;
                            var valorParcela = $('#qntParcelas').find(':selected').attr('data-parcelas');
                            var parcelas = $('#qntParcelas').find(':selected').val();
                            var cardname = document.getElementById("cartao-nome").innerText;
                            var dados = $("#formPagamentoCartaoCredito").serializeArray();
                            dados.push({name: "hashCartao", value: hashCartao});
                            dados.push({name: "tokenCartao", value: tokenCartao});
                            dados.push({name: "valorParcela", value: valorParcela});	
                            dados.push({name: "parcelas", value: parcelas});					
                            dados.push({name: "cardname", value: cardname});	                            		

                            $.ajax({
                                method: "POST",
                                url: "pagseguro/associado/credito/anuidade",
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                data: $.param(dados),
                                dataType: 'json',
                                success: function (retorna) {
                                    if(retorna.message == 'error'){
                                        window.location.href = "https://www.sistemas.intercom.org.br?status=error";
                                    }
                                    else{
                                        window.location.href = "https://www.sistemas.intercom.org.br?status=sucess";
                                    }
                                },
                                error: function (retorna) {
                                }
                            });
                        }
                    });
                }
            },
            async pagarBoleto(){
                this.loading = true;

                await PagSeguroDirectPayment.onSenderHashReady((retorno) => {
                    if (retorno.status == 'error') {
                        this.loading = false;
                        this.message('Erro', 'O Pagseguro pode estar com lentidão ou instabilidade, tente novamente em alguns minutos', 'error');

                        return false;
                    } else {
                        this.form.hashBoleto = retorno.senderHash
                        this.form.metodo = "boleto"


                         this.$validator.validateAll().then((valid) => {
                            if(valid) {
                                this.message('Aguarde...', 'Estamos processando seu pagamento', 'info', -1);

                                setTimeout(() => {

                                    var dados = this.form;

                                    $.ajax({
                                        method: "POST",
                                        url: "pagseguro/associado/boleto/anuidade",
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        data: $.param(dados),
                                        dataType: 'json',
                                        success: (res) => {
                                            if (res.message == 'error') {
                                                this.message('Erro', 'Erro ao processar o pagamento, o Pagseguro pode estar com lentidão ou instabilidade, tente novamente em alguns minutos.', 'error', -1);
                                                this.loading = false;

                                            } else {
                                                this.message('Sucesso', 'Seu pagamento foi processado com sucesso', 'success', -1);
                                                this.loading = false;

                                                window.open(res.response['paymentLink'],'_blank');
                                            }

                                        },
                                        error: (error) => {
                                            if(error.response.status == 422) {
                                                if(error.response.data.message == "The given data was invalid.") {
                                                    this.loading = false
                                                    return this.message('Erro', 'Erro ao processar o pagamento, o Pagseguro pode estar com lentidão ou instabilidade, tente novamente em alguns minutos', 'error');
                                                }
                                            }
                                            if(error.response.status == 500) {
                                                this.loading = false
                                                this.message('Erro', 'Erro ao processar o pagamento, atualize sua página e tente novamente.', 'error');
                                            }
                                            if(error.response.status == 403) {
                                                if(error.response.data.message == "This action is unauthorized.") {
                                                    this.loading = false
                                                    this.message('Erro', 'Ação não autorizada.', 'error');
                                                }
                                            }
                                        }
                                    });
                                },1000)
                            } else {
                                this.loading = false
                                this.message('Erro', 'Erro ao processar o pagamento, o Pagseguro pode estar com lentidão ou instabilidade, tente novamente em alguns minutos', 'error');
                            }
                        })
                    }
                });
            }
        },
        created() {
            this.getProdutos()
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
