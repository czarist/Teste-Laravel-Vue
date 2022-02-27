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
                                    <input type="hidden" name="ativo" id="ativo" :value="selected.ativo">
                                    <input type="hidden" name="cpf" id="cpf" :value="selected.cpf">
                                    <input type="hidden" name="numCartao" id="numCartao" :value="form.numCartao">
                                    <input type="hidden" name="cvv" id="cvv" :value="form.cvv">
                                    <input type="hidden" name="validade" id="validade" :value="form.validade">
                                    <input type="hidden" name="id" id="id" :value="selected.id">
                                    <input type="hidden" name="metodo" id="metodo" :value="selected.metodo">
                                    <input type="hidden" name="name" id="name" :value="selected.name">
                                </form>
                            </div>
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
                {{ hasCredito == true ? "Pagar" : "Gerar Boleto" }}
            </b-button>
        </template>
                <notifications group="submit" position="center bottom" />

    </b-modal>
</template>

<script>
    import MixinsGlobal from  '../mixins/global-mixins'
    import debounce from 'debounce'

    export default {
        props: ['selectedPagar'],
        mixins: [ MixinsGlobal],
        data() {
            return {            
                loading: false,
                url: process.env.MIX_BASE_URL,
                amount: "0.20",
                selected: this.selectedPagar,
                form: {
                    metodo : "credito",
                    _method : "post",
                    id : this.selected ? this.selected.id : null,
                    name : this.selected ? this.selected.name : null,
                    email : this.selected ? this.selected.email : null,
                    cpf : this.selected ? this.selected.cpf : null,
                    estrangeiro : this.selected ? this.selected.estrangeiro : null,
                    passaporte : this.selected ? this.selected.passaporte : null,
                    data_nascimento : this.selected ? this.selected.data_nascimento : null,
                    sexo_id : this.selected ? this.selected.sexo_id : null,
                    celular : this.selected ? this.selected.celular : null,
                    instituicao_id : this.selected ? this.selected.instituicao_id : null,
                    titulacao_id : this.selected ? this.selected.titulacao_id : null,
                    anuidade2022 : this.selected ? this.selected.anuidade2022 : null,
                    ativo : this.selected ? this.selected.ativo: null,
                },
            }
        },
        watch: {
            selected(){
                if(this.selected){
                    this.form.metodo = "credito"
                    this.form._method = "post"
                    this.form.id = this.selected.id
                    this.form.name = this.selected.name
                    this.form.email = this.selected.email
                    this.form.password = this.selected.password
                    this.form.cpf = this.selected.cpf
                    this.form.estrangeiro = this.selected.estrangeiro
                    this.form.passaporte = this.selected.passaporte
                    this.form.anuidade2022 = this.selected.anuidade2022
                    this.form.ativo = this.selected.ativo
                }
                this.listarMeiosPag()

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
            async getEstados(){
                await axios.get(`${process.env.MIX_BASE_URL}/get/estados`).then( res => {
                    this.estados = res.data
                })
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
                var numCartao = this.form.numCartao.substr(0, 7);
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
                        
                        
                        
                    },
                    error: function (retorno) {
                    }
                });
                let nameBand = document.getElementById("cartao-nome").innerText
                console.log('validarBanderia **depois do call recupParcelas: '+ nameBand);
                this.form.bandeira = nameBand;
                this.recupParcelas(nameBand);
                
            },
            recupParcelas(bandeira){
                console.log('recupParcelas')
                var noIntInstalQuantity = $('#noIntInstalQuantity').val();
                console.log('noIntInstalQuantity', noIntInstalQuantity)                
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
                        // callback para chamadas que falharam.
                    },
                    complete: function (retorno) {
                        // Callback para todas chamadas.
                    }
                });

            },
            save(){
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
                        // Callback para chamadas que falharam.
                    },
                    complete: function (retorno) {
                        // Callback para todas chamadas.                
                    }
                });		

                function recupHashCartao(tokenCartao) {
                    console.log('chamou recupHashCartao')
                    PagSeguroDirectPayment.onSenderHashReady(function (retorno) {
                        if (retorno.status == 'error') {
                            console.log(retorno.message);
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
                            console.log('dados: '+ JSON.stringify(dados));

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
            }
        },
        created() {
            
        },

    }

</script>


<style scoped>
    ::v-deep .modal-backdrop {
        opacity: 0.5 !important;
    }
</style>
