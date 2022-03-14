<template>
    <b-modal id="pagar" size="xl">
        <template #modal-header="{ close }">
            <div class="text-center">
               <p style="font-size:18px !important; text-align:center !important;">Escolha uma forma de Pagamento</p>
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

                            <div class="container hidden" id="retorno_ok">
                                <div class="section-head style-3 text-center z mb-3 alert alert-success" role="alert">
                                    <h2 class="title" id="retorno_titulo_ok"></h2>
                                    <p id="retorno_texto_ok"></p>
                                </div>
                            </div>
                            <div class="container hidden" id="retorno_erro">
                                <div class="section-head style-3 text-center z mb-3 alert alert-danger" role="alert">
                                    <h2 class="title" id="retorno_titulo"></h2>
                                    <p id="retorno_texto"></p>
                                    <div>
                                        <b-button
                                            size="xl"
                                            variant="outline-danger"
                                            @click="recarregar()"
                                        >
                                            Voltar
                                        </b-button>
                                    </div>
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
                                            <div class="container">
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
                                                v-mask="'##/##'"
                                            ></b-form-input>
                                            <span class="invalid-feedback" style="font-size:12px !important;">
                                                Ex: Formato da validade é 20/22
                                            </span>

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
                                        <input type="hidden" name="numCartao" id="numCartao" :value="form.numCartao">
                                        <input type="hidden" name="cvv" id="cvv" :value="form.cvv">
                                        <input type="hidden" name="validade" id="validade" :value="form.validade">

                                        <input type="hidden" name="associado" id="associado" :value="form.associado">
                                        <input type="hidden" name="metodo" id="metodo" :value="form.metodo">

                                        <input type="hidden" name="id" id="id" :value="form.id">
                                        <input type="hidden" name="ativo" id="ativo" :value="form.ativo">
                                        <input type="hidden" name="name" id="name" :value="form.name">
                                        <input type="hidden" name="rg" id="rg" :value="form.rg">
                                        <input type="hidden" name="orgao_expedidor" id="orgao_expedidor" :value="form.orgao_expedidor">
                                        <input type="hidden" name="data_nascimento" id="data_nascimento" :value="form.data_nascimento">

                                        <input type="hidden" name="sexo_id" id="sexo_id" :value="form.sexo_id">
                                        <input type="hidden" name="telefone" id="telefone" :value="form.telefone">
                                        <input type="hidden" name="celular" id="celular" :value="form.celular">

                                        <input type="hidden" name="titulacao_id" id="titulacao_id" :value="form.titulacao_id">
                                        <input type="hidden" name="instituicao_id" id="instituicao_id" :value="form.instituicao_id">

                                        <input type="hidden" name="enderecoId" id="enderecoId" :value="form.enderecos.id">
                                        <input type="hidden" name="cep" id="cep" :value="form.enderecos.cep">
                                        <input type="hidden" name="estado" id="estado" :value="form.enderecos.estado">
                                        <input type="hidden" name="logradouro" id="logradouro" :value="form.enderecos.logradouro">
                                        <input type="hidden" name="numero" id="numero" :value="form.enderecos.numero">
                                        <input type="hidden" name="bairro" id="bairro" :value="form.enderecos.bairro">
                                        <input type="hidden" name="complemento" id="complemento" :value="form.enderecos.complemento">
                                        <input type="hidden" name="municipio" id="municipio" :value="form.enderecos.municipio.id">
                                        <input type="hidden" name="pais" id="pais" :value="form.pais">
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
                            <div class="text-center">
                                <b-button
                                    :disabled="loading"
                                    size="md"
                                    id="submit_button_boleto"
                                    variant="btn btn-success"
                                    @click="pagarBoleto()"
                                    >Gerar Boleto
                                </b-button>
                            </div>
                        </b-tab>

                    </b-tabs>
                </b-card>
            </div>
             <notifications group="submit" position="center" width="500px" />
        </template>

        <template #modal-footer="{ cancel }">
            <div id="redirecionar_botao" class="hidden">
                <b-button
                    size="xl"
                    variant="outline-success"
                    @click="redirecionar()"
                    :disabled="loading"
                >
                    Área de Pagamentos
                </b-button>
            </div>

            <b-button
                size="md"
                variant="outline-danger"
                @click="cancel()"
                :disabled="loading"
            >
                Cancelar
            </b-button>

            <b-button
                id="submit_button"
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
                id="submit_button_boleto"
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
                produtos: [],
                amount: null,
                form: {
                    metodo: null,
                    numCartao: null,
                    validade: null,
                    cvv: null,
                    bandeira: null,
                    produto: null,
                    enderecos: {
                        id: null,
                        cep: null,
                        estado: null,
                        municipio: {
                            id: null,
                            nome: null
                        },                        
                        pais: null,
                        logradouro: null,
                    },                                
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
                    this.form.telefone = this.selectedPagar.telefone
                    this.form.enderecos = this.selectedPagar.enderecos
                    this.form.instituicao_id = this.selectedPagar.instituicao_id
                    this.form.titulacao_id = this.selectedPagar.titulacao_id
                    this.form.associado = this.selectedPagar.associado
                    this.form.ativo = this.selectedPagar.ativo

                    this.form.valorParcela = this.produtos.find(produto => produto.id == 2).valor
                    this.form.parcelas = 1;

                }
                if(this.form.associado == 1){
                    this.amount = this.produtos.find(produto => produto.id == 1).valor
                    this.form.produto = this.produtos.find(produto => produto.id == 1)
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
            recarregar(){
                window.location.reload();
            },
            redirecionar(){
                window.location.href = '/pagamento';
            },
            async getEstados(){
                await $.ajax({
                    method: "GET",
                    url: "get/estados",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: (res) => {
                        this.estados = res
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
                        //Enviar para o index a imagem da bandeira
                        var imgBand = retorno.brand.name;
                        $('.bandeira-cartao').html("<img src='https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/" + imgBand + ".png'>");
                        $('.cartao-nome').html(imgBand);

                        $('#cartao-bandeira').removeClass('hidden');
                        $('.cartao-nome').removeClass('hidden');
                        $("#retorno_erro").addClass("hidden");
                        $("#submit_button").prop("disabled", false);
                        $('#submit_button_boleto').prop('disabled', false);                        
                        
                    },
                    error: function (retorno) {

                        $("#retorno_erro").removeClass("hidden");
                        $('#retorno_texto').html('Número do cartão invalido, por favor verifique e tente novamente.');
                        $("#submit_button").prop("disabled", true);
                        $('#submit_button_boleto').prop('disabled', true);

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
                        $('#retorno_erro').removeClass('hidden');
                        $('#retorno_texto').html('O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente <br> Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos');
                        $('#submit_button').prop('disabled', true);
                        $('#submit_button_boleto').prop('disabled', true);

                    },
                    complete: function (retorno) {
                        // Callback para todas chamadas.
                    }
                });

            },
            async pagarCredito(){

                await this.$validator.validateAll().then((valid) => {
                    if(valid) {

                        this.message('Aguarde...', 'Estamos processando seu pagamento', 'info');

                        var cardnum = this.form.numCartao.replace(/\-/g, '');  // Número do cartão de crédito
                        var cardname = document.getElementById("cartao-nome").innerText;  // Bandeira do cartão
                        var cardval = this.form.validade.split("/"); // Validade do cartão mes e ano.
                        var cardmes = cardval[0];  // Mês da expiração do cartão
                        var cardano = 20+cardval[1]; // Ano da expiração do cartão, é necessário os 4 dígitos.
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
                                $('#retorno_erro').removeClass('hidden');
                                $('#retorno_texto').html('O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente <br> Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos');
                                $('#submit_button').prop('disabled', true);
                                $('#submit_button_boleto').prop('disabled', true);

                            },
                            complete: function (retorno) {
                                // Callback para todas chamadas.                
                            }
                        });		

                        function recupHashCartao(tokenCartao) {
                            PagSeguroDirectPayment.onSenderHashReady(function (retorno) {
                                if (retorno.status == 'error') {

                                    $('#retorno_erro').removeClass('hidden');
                                    $('#retorno_texto').html('O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente <br> Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos');
                                    $('#submit_button').prop('disabled', true);
                                    $('#submit_button_boleto').prop('disabled', true);


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
                                        url: "pagseguro/associado/credito",
                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                        data: $.param(dados),
                                        dataType: 'json',
                                        success: function (retorna) {
                                            if(retorna.message == 'error'){
                                                
                                                $('#retorno_erro').removeClass('hidden');
                                                $('#retorno_texto').html('O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente <br> Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos');
                                                $("#submit_button").prop("disabled", true);
                                                $('#submit_button_boleto').prop('disabled', true);

                                                
                                                //to mexendo aqui
                                                setTimeout(() => {
                                                    window.location.href = '/pagamento?status=error';
                                                },2000)
                                            }
                                            else{

                                                $('#redirecionar_botao').removeClass('hidden').attr('class', 'text-center');
                                                $('#retorno_ok').removeClass('hidden');
                                                $('#retorno_titulo_ok').html('Sucesso!');
                                                $('#retorno_texto_ok').html('Seu pagamento foi processado com sucesso');
                                                $('#submit_button').prop('disabled', true);
                                                $('#submit_button_boleto').prop('disabled', true);
                                                
                                                setTimeout(() => {
                                                    window.location.href = '/pagamento?status=sucess';
                                                },2000)
                                            }
                                        },
                                        error: function (retorna) {
                                        }
                                    });
                                }
                            });
                        }
                    } else {
                        this.loading = false
                        this.message('Campos Obrigatórios', 'Preencha todos os campos obrigatórios', 'error');
                    }
                })
            },
            async pagarBoleto(){
                this.loading = true;

                await PagSeguroDirectPayment.onSenderHashReady((retorno) => {
                    if (retorno.status == 'error') {
                        console.log(retorno.message);
                        this.loading = false;
                        return false;
                    } else {
                        this.form.hashBoleto = retorno.senderHash
                        this.form.metodo = "boleto"


                         this.$validator.validateAll().then((valid) => {
                            if(valid) {
                                this.message('Aguarde...', 'Estamos processando seu pagamento', 'info');

                                setTimeout(() => {

                                    var dados = this.form

                                    $.ajax({
                                        method: "POST",
                                        url: "pagseguro/associado/boleto",
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        data: $.param(dados),
                                        dataType: 'json',
                                        success: (res) => {
                                            if (res.message == 'error') {} else {

                                                this.message('Erro', 'Erro ao processar o pagamento, O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente. Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos', 'error');
                                                this.loading = false;

                                            }
                                                this.message('Sucesso', 'Seu pagamento foi processado com sucesso', 'success');
                                                this.loading = false;

                                                window.open(res.response['paymentLink'],'_blank');

                                        },
                                        error: (error) => {
                                            if(error.response.status == 422) {
                                                if(error.response.data.message == "The given data was invalid.") {
                                                    this.loading = false
                                                    return this.message('Erro', 'Erro ao processar o pagamento, O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente. Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos', 'error');
                                                }
                                            }
                                            if(error.response.status == 500) {
                                                this.loading = false
                                                this.message('Erro', 'Erro ao processar o pagamento, O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente. Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos.', 'error');
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
                                this.message('Erro', 'Erro ao processar o pagamento, O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente. Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos', 'error');
                            }
                        })
                    }
                });

            },
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
