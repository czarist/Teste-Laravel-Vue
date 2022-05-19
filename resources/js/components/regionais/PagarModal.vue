<template>
  <b-modal id="pagar" size="xl">
    <template #modal-header="{ close }">
      <div class="text-center">
        <div align="center">
          <p style="font-size: 18px !important; text-align: center !important">
            Escolha uma forma de Pagamento
          </p>
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
                    <h2 class="title">
                      Checkout <img :src="baseUrl + '/images/pagseguro.png'" />
                    </h2>
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
                  <div class="section-head style-3 text-center z mb-3 alert alert-danger " role="alert" >
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
                      <b-form-group
                        label="Número do Cartão"
                        label-class="font-weight-bold"
                      >
                        <b-form-input
                          name="numCartao"
                          size="sm"
                          v-model="form.numCartao"
                          @change="validarBanderia()"
                          type="text"
                          :disabled="loading"
                          :class="[
                            'form-control form-control-sm',
                            { 'is-invalid': errors.has(`numCartao`) },
                          ]"
                          v-validate="{ required: true }"
                          aria-describedby="input-1-live-feedback"
                          data-vv-as="Número do Cartão"
                          v-mask="'####-####-####-####'"
                        >
                        </b-form-input>
                        <span
                          v-show="errors.has(`numCartao`)"
                          class="invalid-feedback"
                        >
                          {{ errors.first(`numCartao`) }}
                        </span>

                        <div class="container hidden">
                          <div class="row">
                            <span
                              class="
                                col-6
                                input-group-text
                                bandeira-cartao
                                creditCard
                                hidden
                              "
                              id="cartao-bandeira"
                              style="background-color: #ffffff"
                            ></span>
                            <span
                              type="text"
                              class="
                                col-6
                                input-group-text
                                cartao-nome
                                creditCard
                                form-login-help
                                hidden
                              "
                              id="cartao-nome"
                              style="background-color: #ffffff"
                            ></span>
                          </div>
                        </div>
                      </b-form-group>
                    </b-col>

                    <b-col cols="12" sm="6" lg="6">
                      <b-form-group
                        label="Validade"
                        label-class="font-weight-bold"
                      >
                        <b-form-input
                          name="validade"
                          size="sm"
                          v-model="form.validade"
                          type="text"
                          :disabled="loading"
                          :class="[
                            'form-control form-control-sm',
                            { 'is-invalid': errors.has(`validade`) },
                          ]"
                          v-validate="{ required: true }"
                          aria-describedby="input-1-live-feedback"
                          data-vv-as="Validade"
                          v-mask="'##/##'"
                        ></b-form-input>
                        <span
                          class="invalid-feedback"
                          style="font-size: 12px !important"
                        >
                          Ex: Formato da validade é 20/22
                        </span>

                        <span
                          v-show="errors.has(`validade`)"
                          class="invalid-feedback"
                        >
                          {{ errors.first(`validade`) }}
                        </span>
                      </b-form-group>
                    </b-col>

                    <b-col cols="12" sm="6" lg="6">
                      <b-form-group
                        label="Código de Segurança"
                        label-class="font-weight-bold"
                      >
                        <b-form-input
                          name="cvv"
                          size="sm"
                          v-model="form.cvv"
                          type="text"
                          :disabled="loading"
                          :class="[
                            'form-control form-control-sm',
                            { 'is-invalid': errors.has(`cvv`) },
                          ]"
                          v-validate="{ required: true }"
                          aria-describedby="input-1-live-feedback"
                          data-vv-as="Código de Segurança"
                          v-mask="'####'"
                        ></b-form-input>
                        <span
                          v-show="errors.has(`cvv`)"
                          class="invalid-feedback"
                        >
                          {{ errors.first(`cvv`) }}
                        </span>
                      </b-form-group>
                    </b-col>

                    <b-col cols="12" sm="6" lg="6">
                      <b-form-group
                        label="Quantidade de Parcelas"
                        label-class="font-weight-bold"
                      >
                        <b-form-select
                          :disabled="true"
                          name="qntParcelas"
                          id="qntParcelas"
                          v-validate="{ required: true }"
                          :class="[
                            'form-control form-control-sm',
                            { 'is-invalid': errors.has(`qntParcelas`) },
                          ]"
                          size="sm"
                          data-vv-as="Quantidade de Parcelas"
                          class="form-control form-control-sm"
                          v-model="form.qntParcelas"
                        >
                        </b-form-select>
                        <span
                          v-show="errors.has(`qntParcelas`)"
                          class="invalid-feedback"
                        >
                          {{ errors.first(`qntParcelas`) }}
                        </span>
                      </b-form-group>
                    </b-col>
                  </b-row>

                  <div
                    class="meio-pag-credito"
                    id="meio-pag-credito"
                    name="meio-pag-credito"
                    align="center"
                    style="padding-top: 10px; padding-bottom: 20px"
                  />

                  <div class="hidden">
                    <form
                      method="post"
                      accept-charset="utf-8"
                      name="formPagamentoCartaoCredito"
                      id="formPagamentoCartaoCredito"
                      action=""
                    >
                      <input
                        type="hidden"
                        name="recupHashCartao"
                        id="recupHashCartao"
                        value=""
                      />
                      <input
                        type="hidden"
                        name="numCartao"
                        id="numCartao"
                        :value="form.numCartao"
                      />
                      <input
                        type="hidden"
                        name="cvv"
                        id="cvv"
                        :value="form.cvv"
                      />
                      <input
                        type="hidden"
                        name="validade"
                        id="validade"
                        :value="form.validade"
                      />
                      <input
                        type="hidden"
                        name="metodo"
                        id="metodo"
                        :value="form.metodo"
                      />
                      <input
                        type="hidden"
                        name="anuidade2022"
                        id="anuidade2022"
                        :value="1"
                      />
                      <input type="hidden" name="id" id="id" :value="form.id" />
                      <input
                        type="hidden"
                        name="produto"
                        id="produto"
                        :value="form && form.produto ? form.produto.id : null"
                      />
                    </form>
                  </div>
                </div>
              </b-card-text>
            </b-tab>

            <b-tab title="Boleto">
              <b-card-text>
                <div class="container hidden" id="retorno_ok1">
                  <div class="section-head style-3 text-center z mb-3 alert alert-success" role="alert">
                    <h2 class="title" id="retorno_titulo_ok"></h2>
                    <p id="retorno_texto_ok1"></p>
                  </div>
                </div>
                <div class="container hidden" id="retorno_erro1">
                  <div class="section-head style-3 text-center z mb-3 alert alert-danger " role="alert" >
                    <h2 class="title" id="retorno_titulo1"></h2>
                    <p id="retorno_texto1"></p>
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

                <form
                  class="form-horizontal"
                  action=""
                  method="post"
                  accept-charset="utf-8"
                  name="formPagamentoBoleto"
                  id="formPagamentoBoleto"
                >
                  <fieldset>
                    <div
                      class="meio-pag-boleto"
                      align="center"
                      style="padding-bottom: 20px"
                    ></div>
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
        :disabled="loading"
        size="md"
        variant="outline-success"
        @click="pagarCredito()"
        >Pagar
      </b-button>
    </template>
  </b-modal>
</template>


<script>
import MixinsGlobal from "../mixins/global-mixins";
import debounce from "debounce";

export default {
  props: ["selectedPagar", "id"],
  mixins: [MixinsGlobal],
  data() {
    return {
      loading: false,
      baseUrl: process.env.MIX_BASE_URL,
      amount: null,
      form: {
        metodo: "credito",
        _method: "post",
        id: this.selectedPagar ? this.selectedPagar.id : null,
        name: this.selectedPagar ? this.selectedPagar.name : null,
        email: this.selectedPagar ? this.selectedPagar.email : null,
        cpf: this.selectedPagar ? this.selectedPagar.cpf : null,
        rg: this.selectedPagar ? this.selectedPagar.rg : null,
        orgao_expedidor: this.selectedPagar
          ? this.selectedPagar.orgao_expedidor
          : null,
        estrangeiro: this.selectedPagar ? this.selectedPagar.estrangeiro : null,
        passaporte: this.selectedPagar ? this.selectedPagar.passaporte : null,
        data_nascimento: this.selectedPagar
          ? this.selectedPagar.data_nascimento
          : null,
        sexo_id: this.selectedPagar ? this.selectedPagar.sexo_id : null,
        celular: this.selectedPagar ? this.selectedPagar.celular : null,
        instituicao_id: this.selectedPagar
          ? this.selectedPagar.instituicao_id
          : null,
        titulacao_id: this.selectedPagar
          ? this.selectedPagar.titulacao_id
          : null,
        anuidade2022: null,
        ativo: this.selectedPagar ? this.selectedPagar.ativo : null,
        produto: null,
      },
    };
  },
  watch: {
    selectedPagar() {
      if (this.selectedPagar) {
        this.form.metodo = "credito";
        this.form._method = "post";
        this.form.anuidade2022 = 1;
        this.form.id = this.selectedPagar.id;
        this.form.name = this.selectedPagar.name;
        this.form.email = this.selectedPagar.email;
        this.form.cpf = this.selectedPagar.cpf;
        this.form.rg = this.selectedPagar.rg;
        this.form.orgao_expedidor = this.selectedPagar.orgao_expedidor;
        this.form.estrangeiro = this.selectedPagar.estrangeiro;
        this.form.passaporte = this.selectedPagar.passaporte;
        this.form.data_nascimento = this.selectedPagar.data_nascimento;
        this.form.sexo_id = this.selectedPagar.sexo_id;
        this.form.celular = this.selectedPagar.celular;
        this.form.telefone = this.selectedPagar.telefone;
        this.form.enderecos = this.selectedPagar.enderecos;
        this.form.instituicao_id = this.selectedPagar.instituicao_id;
        this.form.titulacao_id = this.selectedPagar.titulacao_id;
        this.form.associado = this.selectedPagar.associado;
        this.form.ativo = this.selectedPagar.ativo;
        this.form.valorParcela = this.produtos.find(
          (produto) => produto.id == this.selectedPagar.taxa_inscricao.id
        ).valor;
        this.form.parcelas = 1;
      }
      if (this.form.anuidade2022 == 1) {
        this.amount = this.produtos.find(
          (produto) => produto.id == this.selectedPagar.taxa_inscricao.id
        ).valor;
        this.form.produto = this.produtos.find(
          (produto) => produto.id == this.selectedPagar.taxa_inscricao.id
        );
      }

      this.listarMeiosPag();
    },
    numCartao() {
      if (this.form.numCartao) {
        validarBanderia();
      }
    },
  },
  computed: {
    hasCredito() {
      return this.form.numCartao != null ? true : false;
    },
  },
  methods: {
    recarregar() {
      window.location.reload();
    },
    redirecionar() {
      window.location.href = "/pagamento";
    },
    async listarMeiosPag() {
      PagSeguroDirectPayment.getPaymentMethods({
        amount: this.amount,
        success: function (retorno) {
          //Recuperar as bandeiras do cartão de crédito
          $.each(retorno.paymentMethods.CREDIT_CARD.options, function (i, obj) {
            $(".meio-pag-credito").append(
              "<span class='img-band'><img src='https://stc.pagseguro.uol.com.br" +
                obj.images.MEDIUM.path +
                "'></span>"
            );
          });

          //Recuperar as bandeiras do boleto
          $(".meio-pag-boleto").append(
            "<span  class='img-band'><img width='150' height='80' src='https://stc.pagseguro.uol.com.br" +
              retorno.paymentMethods.BOLETO.options.BOLETO.images.MEDIUM.path +
              "'><span>"
          );
        },
        error: function (retorno) {
        },
        complete: function (retorno) {
        },
      });
    },
    validarBanderia() {
      var numCartao = this.form.numCartao.substr(0, 7);
      numCartao = numCartao.replace(/\-/g, "");

      PagSeguroDirectPayment.getBrand({
        cardBin: numCartao,
        success: function (retorno) {
          //Enviar para o index a imagem da bandeira
          var imgBand = retorno.brand.name;
          $(".bandeira-cartao").html("<img src='https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/" + imgBand + ".png'>");
          $(".cartao-nome").html(imgBand);

          $("#cartao-bandeira").removeClass("hidden");
          $(".cartao-nome").removeClass("hidden");
          $("#retorno_erro").addClass("hidden");
          $("#submit_button").prop("disabled", false);
          $("#submit_button_boleto").prop("disabled", false);
        },
        error: function (retorno) {
          $("#retorno_erro").removeClass("hidden");
          $("#retorno_texto").html(
            "Número do cartão inválido, por favor verifique e tente novamente."
          );
          $("#submit_button").prop("disabled", true);
          $("#submit_button_boleto").prop("disabled", true);
        },
      });
      let nameBand = document.getElementById("cartao-nome").innerText;
      this.form.bandeira = nameBand;
      this.recupParcelas(nameBand);
    },
    recupParcelas(bandeira) {
      var noIntInstalQuantity = $("#noIntInstalQuantity").val();
      PagSeguroDirectPayment.getInstallments({
        amount: this.amount,
        maxInstallmentNoInterest: noIntInstalQuantity,

        //Tipo da bandeira
        brand: bandeira,
        success: function (retorno) {
          $.each(retorno.installments, function (ia, obja) {
            $.each(obja, function (ib, objb) {
              //Converter o preço para o formato real com JavaScript
              var valorParcela = objb.installmentAmount
                .toFixed(2)
                .replace(".", ",");

              //Acrecentar duas casas decimais apos o ponto
              var valorParcelaDouble = objb.installmentAmount.toFixed(2);
              //Apresentar quantidade de parcelas e o valor das parcelas para o usuário no campo SELECT
              $("#qntParcelas")
                .show()
                .append(
                  "<option value='" +
                    objb.quantity +
                    "' data-parcelas='" +
                    valorParcelaDouble +
                    "'>" +
                    objb.quantity +
                    " parcelas de R$ " +
                    valorParcela +
                    "</option>"
                );
            });
          });
        },
        error: function (retorno) {

          $("#retorno_erro").removeClass("hidden");
          $("#retorno_texto").html(
            "O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente <br> Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos"
          );
          $("#submit_button").prop("disabled", true);
          $("#submit_button_boleto").prop("disabled", true);
        },
        complete: function (retorno) {
          // Callback para todas chamadas.
        },
      });
    },
    async pagarCredito() {
      this.loading = true;
      await this.$validator.validateAll().then((valid) => {
        if (valid) {
          this.message(
            "Aguarde...",
            "Estamos processando seu pagamento",
            "info"
          );

          var cardnum = this.form.numCartao.replace(/\-/g, ""); // Número do cartão de crédito
          var cardname = document.getElementById("cartao-nome").innerText; // Bandeira do cartão
          var cardval = this.form.validade.split("/"); // Validade do cartão mes e ano.
          var cardmes = cardval[0]; // Mês da expiração do cartão
          var cardano = 20 + cardval[1]; // Ano da expiração do cartão, é necessário os 4 dígitos.
          var cardcvv = this.form.cvv; // CVV do cartão

          var urlPagarCredito = this.baseUrl + "/pagseguro/regionais/credito";

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
              if (retorno.error == true) {
                var errorPag = '';

                if(retorno.errors[10006]){
                  errorPag += "Código de Segurança digitado com o comprimento inválido <br>";
                }
                    
                if(errorPag == ''){
                  errorPag += "Campos de Número do Cartão, Validade ou Código de Segurança digitado é inválido <br>";
                }

                $("#retorno_erro").removeClass("hidden");
                $("#retorno_texto").html(errorPag);
              }
            },
            complete: function (retorno) {
              // Callback para todas chamadas.
            },
          });

          function recupHashCartao(tokenCartao) {
            PagSeguroDirectPayment.onSenderHashReady(function (retorno) {
              if (retorno.status == "error") {
                $("#retorno_erro").removeClass("hidden");
                $("#retorno_texto").html("O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente <br> Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos");
                $("#submit_button").prop("disabled", true);
                $("#submit_button_boleto").prop("disabled", true);

                return false;
              } else {
                var hashCartao = retorno.senderHash;
                var valorParcela = $("#qntParcelas")
                  .find(":selected")
                  .attr("data-parcelas");
                var parcelas = $("#qntParcelas").find(":selected").val();
                var cardname = document.getElementById("cartao-nome").innerText;
                var dados = $("#formPagamentoCartaoCredito").serializeArray();
                dados.push({ name: "hashCartao", value: hashCartao });
                dados.push({ name: "tokenCartao", value: tokenCartao });
                dados.push({ name: "valorParcela", value: valorParcela });
                dados.push({ name: "parcelas", value: parcelas });
                dados.push({ name: "cardname", value: cardname });

                $.ajax({
                  method: "POST",
                  url: urlPagarCredito,
                  headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                      "content"
                    ),
                  },
                  data: $.param(dados),
                  dataType: "json",

                  success: function (retorna) {
                    if (retorna.message == "error") {
                      var errorPag = '';

                      if(retorna.response.error){   
                        retorna.response.error.forEach(function(error){

                          if(error.code == 53012){
                            errorPag += "E-mail enviado para o pagseguro não foi aceito, entre no seu perfil e atualize seu e-mail <br>";
                          }
                          if(error.code == 53015){
                            errorPag += "Nome enviado para o pagseguro não foi aceito, entre no seu perfil e atualize seu nome completo <br>";
                          }
                          if(error.code == 5003){
                            errorPag += "Falha de comunicação com a instituição financeira, atualize a pagina e tente novamente <br>";
                          }
                          if(error.code == 10000){
                            errorPag += "Marca de cartão de crédito inválida <br>";
                          }
                          if(error.code == 10001){
                            errorPag += "Número do cartão de crédito com comprimento inválido <br>";
                          }
                          if(error.code == 10002){
                            errorPag += "Formato da data inválida, entre no seu perfil e atualize sua data de nascimento <br>";
                          }
                          if(error.code == 10003){
                            errorPag += "Campo de segurança CVV inválido, atualize a pagina e tente novamente <br>";
                          }
                          if(error.code == 10004){
                            errorPag += "Código de verificação CVV é obrigatório, atualize a pagina e tente novamente <br>";
                          }
                          if(error.code == 10006){
                            errorPag += "Campo de segurança com comprimento inválido, atualize a pagina e tente novamente <br>";
                          }
                          if(error.code == 53010){
                            errorPag += "O e-mail do remetente é obrigatório, entre no seu perfil e atualize seu e-mail <br>";
                          }
                          if(error.code == 53011){
                            errorPag += "Email do remetente com comprimento inválido, entre no seu perfil e atualize seu e-mail <br>";
                          }
                          // if(error.code == 53012){
                          //   errorPag += "Email do remetente está com valor inválido, entre no seu perfil e atualize seu e-mail <br>";
                          // }
                          if(error.code == 53013){
                            errorPag += "O nome do remetente é obrigatório, entre no seu perfil e atualize seu nome <br>";
                          }
                          if(error.code == 53014){
                            errorPag += "Nome do remetente está com comprimento inválido, entre no seu perfil e atualize seu nome <br>";
                          }
                          // if(error.code == 53015){
                          //   errorPag += "Nome do remetente está com valor inválido, entre no seu perfil e atualize seu nome <br>";
                          // }
                          if(error.code == 53017){
                            errorPag += "Foi detectado algum erro nos dados do seu CPF, entre em contato com suporte <br>";
                          }
                          if(error.code == 53018){
                            errorPag += "O código de área do remetente é obrigatório, entre no seu perfil e atualize seu telefone e celular <br>";
                          }
                          if(error.code == 53019){
                            errorPag += "Há um conflito com o código de área informado, em relação a outros dados seus. Entre no seu perfil e atualize seu telefone e celular <br>";
                          }
                          if(error.code == 53020){
                            errorPag += "É necessário um telefone do remetente. Entre no seu perfil e atualize seu telefone e celular <br>";
                          }
                          if(error.code == 53021){
                            errorPag += "Valor inválido do telefone do remetente. Entre no seu perfil e atualize seu telefone e celular <br>";
                          }
                          if(error.code == 53022){
                            errorPag += "É necessário o código postal do endereço de entrega. Entre no seu perfil e atualize seu endereço <br>";
                          }
                          if(error.code == 53023){
                            errorPag += "Código postal está com valor inválido. Entre no seu perfil e atualize seu endereço <br>";
                          }
                          if(error.code == 53037){
                            errorPag += "O token do cartão de crédito é necessário. atualize a pagina e tente novamente <br>";
                          }
                          if(error.code == 53042){
                            errorPag += "O nome do titular do cartão de crédito é obrigatório. Entre no seu perfil e atualize seu Nome Completo <br>";
                          }
                          if(error.code == 53043){
                            errorPag += "Nome do titular do cartão de crédito está com o comprimento inválido. Entre no seu perfil e atualize seu Nome Completo <br>";
                          }
                          // if(error.code == 53044){
                          //   errorPag += "O nome informado no formulário do cartão de Crédito precisa ser escrito exatamente da mesma forma que consta no seu cartão obedecendo inclusive, abreviaturas e grafia errada. Entre no seu perfil e atualize seu Nome Completo <br>";
                          // }
                          if(error.code == 53044){
                            errorPag += "O nome completo não é valido e não foi aceito pelo pagseguro. Entre no seu perfil e atualize seu Nome Completo <br>";
                          }

                          if(error.code == 53045){
                            errorPag += "O CPF do titular do cartão de crédito é obrigatório. Entre em contato com o suporte <br>";
                          }
                          if(error.code == 53046){
                            errorPag += "O CPF do titular do cartão de crédito está com valor inválido. Entre em contato com o suporte <br>";
                          }
                          if(error.code == 53047){
                            errorPag += "A data de nascimento do titular do cartão de crédito é necessária. Entre no seu perfil e atualize sua data de nascimento <br>";
                          }
                          if(error.code == 53048){
                            errorPag += "A data de nascimento do Titular do cartão de crédito está com valor inválido. Entre no seu perfil e atualize sua data de nascimento <br>";
                          }
                          if(error.code == 53049){
                            errorPag += "O código de área do titular do cartão de crédito é obrigatório. Entre no seu perfil e atualize seu telefone e celular <br>";
                          }
                          if(error.code == 53051){
                            errorPag += "O telefone do titular do cartão de crédito é obrigatório. Entre no seu perfil e atualize seu telefone e celular <br>";
                          }
                          if(error.code == 53052){
                            errorPag += "O número de Telefone do titular do cartão de crédito está com valor inválido. Entre no seu perfil e atualize seu telefone e celular <br>";
                          }
                          if(error.code == 53053){
                            errorPag += "É necessário o código postal do endereço de cobrança. Entre no seu perfil e atualize seu endereço <br>";
                          }
                          if(error.code == 53054){
                            errorPag += "O código postal do endereço de cobrança está com valor inválido. Entre no seu perfil e atualize seu endereço <br>";
                          }
                          if(error.code == 53055){
                            errorPag += "O endereço de cobrança é obrigatório. Entre no seu perfil e atualize seu endereço <br>";
                          }
                          if(error.code == 53056){
                            errorPag += "A rua, no endereço de cobrança está com comprimento inválido. Entre no seu perfil e atualize seu endereço <br>";
                          }
                          if(error.code == 53057){
                            errorPag += "É necessário o número no endereço de cobrança. Entre no seu perfil e atualize seu endereço <br>";
                          }
                          if(error.code == 53058){
                            errorPag += "Número de endereço de cobrança está com comprimento inválido. Entre no seu perfil e atualize seu endereço <br>";
                          }
                          if(error.code == 53059){
                            errorPag += "Endereço de cobrança complementar está com comprimento inválido. Entre no seu perfil e atualize seu endereço <br>";
                          }
                          if(error.code == 53060){
                            errorPag += "O endereço de cobrança é obrigatório. Entre no seu perfil e atualize seu endereço <br>";
                          }
                          if(error.code == 53061){
                            errorPag += "O endereço de cobrança está com tamanho inválido. Entre no seu perfil e atualize seu endereço <br>";
                          }
                          if(error.code == 53062){
                            errorPag += "É necessário informar a cidade no endereço de cobrança. Entre no seu perfil e atualize seu endereço <br>";
                          }
                          if(error.code == 53063){
                            errorPag += "O item Cidade, está com o comprimento inválido no endereço de cobrança. Entre no seu perfil e atualize seu endereço <br>";
                          }
                          if(error.code == 53064){
                            errorPag += "O estado, no endereço de cobrança é obrigatório. Entre no seu perfil e atualize seu endereço <br>";
                          }
                          if(error.code == 53065){
                            errorPag += "No endereço de cobrança, o estado está com algum valor inválido. Entre no seu perfil e atualize seu endereço <br>";
                          }
                          if(error.code == 53066){
                            errorPag += "O endereço de cobrança do país é obrigatório. Entre no seu perfil e atualize seu endereço <br>";
                          }
                          if(error.code == 53067){
                            errorPag += "No endereço de cobrança, o país está com um comprimento inválido. Entre no seu perfil e atualize seu endereço <br>";
                          }
                          if(error.code == 53068){
                            errorPag += "O email do destinatário está com tamanho inválido. Entre no seu perfil e atualize seu email <br>";
                          }
                          if(error.code == 53069){
                            errorPag += "Valor inválido do e-mail do destinatário. Entre no seu perfil e atualize seu email <br>";
                          }
                          if(error.code == 53085){
                            errorPag += "Método de pagamento indisponível. Entre em contato com suporte <br>";
                          }
                          if(error.code == 53087){
                            errorPag += "Método de pagamento indisponível. Entre em contato com suporte <br>";
                          }
                          if(error.code == 53091){
                            errorPag += "O Hash do remetente está inválido. Atualize sua pagina e tente novamente <br>";
                          }
                          if(error.code == 53092){
                            errorPag += "A Bandeira do cartão de crédito não é aceita. Atualize sua pagina e tente com outro cartão <br>";
                          }
                          if(error.code == 53105){
                            errorPag += "As informações do remetente foram fornecidas, portanto o e-mail também deve ser informado. Entre no seu perfil e atualize o seu email <br>";
                          }
                          if(error.code == 53106){
                            errorPag += "O titular do cartão de crédito está incompleto. Entre no seu perfil e atualize o seu nome completo <br>";
                          }
                          if(error.code == 53110){
                            errorPag += "Banco EFT é obrigatório, tente com outro cartão <br>";
                          }
                          if(error.code == 53111){
                            errorPag += "Banco EFT não é aceito, tente com outro cartão <br>";
                          }
                          if(error.code == 53115){
                            errorPag += "Valor inválido da data de nascimento do remetente, entre no seu perfil e atualize sua data de nascimento<br>";
                          }
                          if(error.code == 53122){
                            errorPag += "Erro entre em contato com o suporte, erro 53122 <br>";
                          }
                          if(error.code == 53141){
                            errorPag += "Erro entre em contato com o suporte, erro 53141 <br>";
                          }
                          if(error.code == 53142){
                            errorPag += "O cartão de crédito está com o token inválido, atualize a pagina e tente novamente <br>";
                          }
                        });
                      }
                      $("#retorno_erro").removeClass("hidden");
                        
                      if(errorPag == ''){
                        errorPag += "Erro ao processar o pagamento, caso não tenha recebido nenhum informativo de erro acima entre em contato com o suporte, email: suporte@kirc.com.br ou whatsapp (11) 96365-1888 <br>";
                      }

                      $("#retorno_texto").html(errorPag);
                      $("#submit_button").prop("disabled", true);
                      $("#submit_button_boleto").prop("disabled", true);

                      //to mexendo aqui
                      // setTimeout(() => {
                      //   window.location.href = "/pagamento?status=error";
                      // }, 2000);

                    } else {
                      $("#redirecionar_botao").removeClass("hidden").attr("class", "text-center");
                      $("#retorno_ok").removeClass("hidden");
                      $("#retorno_titulo_ok").html("Sucesso!");
                      $("#retorno_texto_ok").html(
                        "Seu pagamento foi processado com sucesso"
                      );
                      $("#submit_button").prop("disabled", true);
                      $("#submit_button_boleto").prop("disabled", true);

                      setTimeout(() => {
                        window.location.href = "/pagamento?status=sucess";
                      }, 2000);

                    }
                  },
                  error: function (retorna) {

                    $("#retorno_erro").removeClass("hidden");
                    $("#retorno_texto").html(
                      "O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente <br> Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos"
                    );
                    $("#submit_button").prop("disabled", true);
                    $("#submit_button_boleto").prop("disabled", true);
                  },
                });
              }
            });
          }
        } else {
          this.loading = false;
          this.message(
            "Campos Obrigatórios",
            "Preencha todos os campos obrigatórios",
            "error"
          );
        }
      });
    },
    async pagarBoleto() {
      this.loading = true;

      var urlPagarCredito = this.baseUrl + "/pagseguro/regionais/boleto";

      await PagSeguroDirectPayment.onSenderHashReady((retorno) => {
        var hashboleto = retorno.senderHash;
        if (retorno.status == "error") {
          this.loading = false;
          this.message("Erro", "O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente. Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos","error");

          return false;
        } else {
          this.$validator.validateAll().then((valid) => {
            if (valid) {
              this.message("Aguarde...", "Estamos processando seu pagamento", "info");

              var dados = this.form;
              dados.hashBoleto = hashboleto;

              setTimeout(() => {
                $.ajax({
                  method: "POST",
                  url: urlPagarCredito,
                  headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                      "content"
                    ),
                  },
                  data: $.param(dados),
                  dataType: "json",
                  success: (res) => {
                    if (res.message == "error") {

                      var errorPag = '';

                      if(res.response.error){   
                          res.response.error.forEach(function(error){

                              if(error.code == 53012){
                              errorPag += "E-mail enviado para o pagseguro não foi aceito, entre no seu perfil e atualize seu e-mail <br>";
                              }
                              if(error.code == 53015){
                              errorPag += "Nome enviado para o pagseguro não foi aceito, entre no seu perfil e atualize seu nome completo <br>";
                              }
                              if(error.code == 5003){
                              errorPag += "Falha de comunicação com a instituição financeira, atualize a pagina e tente novamente <br>";
                              }
                              if(error.code == 10000){
                              errorPag += "Marca de cartão de crédito inválida <br>";
                              }
                              if(error.code == 10001){
                              errorPag += "Número do cartão de crédito com comprimento inválido <br>";
                              }
                              if(error.code == 10002){
                              errorPag += "Formato da data inválida, entre no seu perfil e atualize sua data de nascimento <br>";
                              }
                              if(error.code == 10003){
                              errorPag += "Campo de segurança CVV inválido, atualize a pagina e tente novamente <br>";
                              }
                              if(error.code == 10004){
                              errorPag += "Código de verificação CVV é obrigatório, atualize a pagina e tente novamente <br>";
                              }
                              if(error.code == 10006){
                              errorPag += "Campo de segurança com comprimento inválido, atualize a pagina e tente novamente <br>";
                              }
                              if(error.code == 53010){
                              errorPag += "O e-mail do remetente é obrigatório, entre no seu perfil e atualize seu e-mail <br>";
                              }
                              if(error.code == 53011){
                              errorPag += "Email do remetente com comprimento inválido, entre no seu perfil e atualize seu e-mail <br>";
                              }
                              // if(error.code == 53012){
                              //   errorPag += "Email do remetente está com valor inválido, entre no seu perfil e atualize seu e-mail <br>";
                              // }
                              if(error.code == 53013){
                              errorPag += "O nome do remetente é obrigatório, entre no seu perfil e atualize seu nome <br>";
                              }
                              if(error.code == 53014){
                              errorPag += "Nome do remetente está com comprimento inválido, entre no seu perfil e atualize seu nome <br>";
                              }
                              // if(error.code == 53015){
                              //   errorPag += "Nome do remetente está com valor inválido, entre no seu perfil e atualize seu nome <br>";
                              // }
                              if(error.code == 53017){
                              errorPag += "Foi detectado algum erro nos dados do seu CPF, entre em contato com suporte <br>";
                              }
                              if(error.code == 53018){
                              errorPag += "O código de área do remetente é obrigatório, entre no seu perfil e atualize seu telefone e celular <br>";
                              }
                              if(error.code == 53019){
                              errorPag += "Há um conflito com o código de área informado, em relação a outros dados seus. Entre no seu perfil e atualize seu telefone e celular <br>";
                              }
                              if(error.code == 53020){
                              errorPag += "É necessário um telefone do remetente. Entre no seu perfil e atualize seu telefone e celular <br>";
                              }
                              if(error.code == 53021){
                              errorPag += "Valor inválido do telefone do remetente. Entre no seu perfil e atualize seu telefone e celular <br>";
                              }
                              if(error.code == 53022){
                              errorPag += "É necessário o código postal do endereço de entrega. Entre no seu perfil e atualize seu endereço <br>";
                              }
                              if(error.code == 53023){
                              errorPag += "Código postal está com valor inválido. Entre no seu perfil e atualize seu endereço <br>";
                              }
                              if(error.code == 53037){
                              errorPag += "O token do cartão de crédito é necessário. atualize a pagina e tente novamente <br>";
                              }
                              if(error.code == 53042){
                              errorPag += "O nome do titular do cartão de crédito é obrigatório. Entre no seu perfil e atualize seu Nome Completo <br>";
                              }
                              if(error.code == 53043){
                              errorPag += "Nome do titular do cartão de crédito está com o comprimento inválido. Entre no seu perfil e atualize seu Nome Completo <br>";
                              }
                              // if(error.code == 53044){
                              //   errorPag += "O nome informado no formulário do cartão de Crédito precisa ser escrito exatamente da mesma forma que consta no seu cartão obedecendo inclusive, abreviaturas e grafia errada. Entre no seu perfil e atualize seu Nome Completo <br>";
                              // }
                              if(error.code == 53044){
                              errorPag += "O nome completo não é valido e não foi aceito pelo pagseguro. Entre no seu perfil e atualize seu Nome Completo <br>";
                              }

                              if(error.code == 53045){
                              errorPag += "O CPF do titular do cartão de crédito é obrigatório. Entre em contato com o suporte <br>";
                              }
                              if(error.code == 53046){
                              errorPag += "O CPF do titular do cartão de crédito está com valor inválido. Entre em contato com o suporte <br>";
                              }
                              if(error.code == 53047){
                              errorPag += "A data de nascimento do titular do cartão de crédito é necessária. Entre no seu perfil e atualize sua data de nascimento <br>";
                              }
                              if(error.code == 53048){
                              errorPag += "A data de nascimento do Titular do cartão de crédito está com valor inválido. Entre no seu perfil e atualize sua data de nascimento <br>";
                              }
                              if(error.code == 53049){
                              errorPag += "O código de área do titular do cartão de crédito é obrigatório. Entre no seu perfil e atualize seu telefone e celular <br>";
                              }
                              if(error.code == 53051){
                              errorPag += "O telefone do titular do cartão de crédito é obrigatório. Entre no seu perfil e atualize seu telefone e celular <br>";
                              }
                              if(error.code == 53052){
                              errorPag += "O número de Telefone do titular do cartão de crédito está com valor inválido. Entre no seu perfil e atualize seu telefone e celular <br>";
                              }
                              if(error.code == 53053){
                              errorPag += "É necessário o código postal do endereço de cobrança. Entre no seu perfil e atualize seu endereço <br>";
                              }
                              if(error.code == 53054){
                              errorPag += "O código postal do endereço de cobrança está com valor inválido. Entre no seu perfil e atualize seu endereço <br>";
                              }
                              if(error.code == 53055){
                              errorPag += "O endereço de cobrança é obrigatório. Entre no seu perfil e atualize seu endereço <br>";
                              }
                              if(error.code == 53056){
                              errorPag += "A rua, no endereço de cobrança está com comprimento inválido. Entre no seu perfil e atualize seu endereço <br>";
                              }
                              if(error.code == 53057){
                              errorPag += "É necessário o número no endereço de cobrança. Entre no seu perfil e atualize seu endereço <br>";
                              }
                              if(error.code == 53058){
                              errorPag += "Número de endereço de cobrança está com comprimento inválido. Entre no seu perfil e atualize seu endereço <br>";
                              }
                              if(error.code == 53059){
                              errorPag += "Endereço de cobrança complementar está com comprimento inválido. Entre no seu perfil e atualize seu endereço <br>";
                              }
                              if(error.code == 53060){
                              errorPag += "O endereço de cobrança é obrigatório. Entre no seu perfil e atualize seu endereço <br>";
                              }
                              if(error.code == 53061){
                              errorPag += "O endereço de cobrança está com tamanho inválido. Entre no seu perfil e atualize seu endereço <br>";
                              }
                              if(error.code == 53062){
                              errorPag += "É necessário informar a cidade no endereço de cobrança. Entre no seu perfil e atualize seu endereço <br>";
                              }
                              if(error.code == 53063){
                              errorPag += "O item Cidade, está com o comprimento inválido no endereço de cobrança. Entre no seu perfil e atualize seu endereço <br>";
                              }
                              if(error.code == 53064){
                              errorPag += "O estado, no endereço de cobrança é obrigatório. Entre no seu perfil e atualize seu endereço <br>";
                              }
                              if(error.code == 53065){
                              errorPag += "No endereço de cobrança, o estado está com algum valor inválido. Entre no seu perfil e atualize seu endereço <br>";
                              }
                              if(error.code == 53066){
                              errorPag += "O endereço de cobrança do país é obrigatório. Entre no seu perfil e atualize seu endereço <br>";
                              }
                              if(error.code == 53067){
                              errorPag += "No endereço de cobrança, o país está com um comprimento inválido. Entre no seu perfil e atualize seu endereço <br>";
                              }
                              if(error.code == 53068){
                              errorPag += "O email do destinatário está com tamanho inválido. Entre no seu perfil e atualize seu email <br>";
                              }
                              if(error.code == 53069){
                              errorPag += "Valor inválido do e-mail do destinatário. Entre no seu perfil e atualize seu email <br>";
                              }
                              if(error.code == 53085){
                              errorPag += "Método de pagamento indisponível. Entre em contato com suporte <br>";
                              }
                              if(error.code == 53087){
                              errorPag += "Método de pagamento indisponível. Entre em contato com suporte <br>";
                              }
                              if(error.code == 53091){
                              errorPag += "O Hash do remetente está inválido. Atualize sua pagina e tente novamente <br>";
                              }
                              if(error.code == 53092){
                              errorPag += "A Bandeira do cartão de crédito não é aceita. Atualize sua pagina e tente com outro cartão <br>";
                              }
                              if(error.code == 53105){
                              errorPag += "As informações do remetente foram fornecidas, portanto o e-mail também deve ser informado. Entre no seu perfil e atualize o seu email <br>";
                              }
                              if(error.code == 53106){
                              errorPag += "O titular do cartão de crédito está incompleto. Entre no seu perfil e atualize o seu nome completo <br>";
                              }
                              if(error.code == 53110){
                              errorPag += "Banco EFT é obrigatório, tente com outro cartão <br>";
                              }
                              if(error.code == 53111){
                              errorPag += "Banco EFT não é aceito, tente com outro cartão <br>";
                              }
                              if(error.code == 53115){
                              errorPag += "Valor inválido da data de nascimento do remetente, entre no seu perfil e atualize sua data de nascimento<br>";
                              }
                              if(error.code == 53122){
                              errorPag += "Erro entre em contato com o suporte, erro 53122 <br>";
                              }
                              if(error.code == 53141){
                              errorPag += "Erro entre em contato com o suporte, erro 53141 <br>";
                              }
                              if(error.code == 53142){
                              errorPag += "O cartão de crédito está com o token inválido, atualize a pagina e tente novamente <br>";
                              }
                          });
                      }

                      if(errorPag == ''){
                          errorPag += "Erro ao processar o pagamento, caso não tenha recebido nenhum informativo de erro acima entre em contato com o suporte, email: suporte@kirc.com.br ou whatsapp (11) 96365-1888 <br>";
                      }

                      $("#retorno_erro1").removeClass("hidden");
                      $("#retorno_texto1").html(errorPag);
                      $("#submit_button").prop("disabled", true);
                      $("#submit_button_boleto").prop("disabled", true);

                      setTimeout(() => {
                          window.location.href = "/pagamento?status=error";
                      }, 10000);

                    } else {

                      this.message(  "Sucesso","Seu pagamento foi processado com sucesso","success");
                      this.loading = false;

                      window.open(res.response["paymentLink"], "_blank");
                    }
                  },
                  error: (error) => {
                    if (error.response.status == 422) {
                      if (
                        error.response.data.message ==
                        "The given data was invalid."
                      ) {
                        this.loading = false;
                        return this.message(
                          "Erro",
                          "Erro ao processar o pagamento, O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente. Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos",
                          "error"
                        );
                      }
                    }
                    if (error.response.status == 500) {
                      this.loading = false;
                      this.message(
                        "Erro",
                        "Erro ao processar o pagamento, atualize sua página e tente novamente.",
                        "error"
                      );
                    }
                    if (error.response.status == 403) {
                      if (
                        error.response.data.message ==
                        "This action is unauthorized."
                      ) {
                        this.loading = false;
                        this.message("Erro", "Ação não autorizada.", "error");
                      }
                    }
                  },
                });
              }, 1000);
            } else {
              this.loading = false;
              this.message(
                "Erro",
                "Erro ao processar o pagamento, O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente. Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos",
                "error"
              );
            }
          });
        }
      });
    },
    async getProdutos() {
      let urlgetProdutos = this.baseUrl + "/get/produtos-regionais";
      await $.ajax({
        method: "GET",
        url: urlgetProdutos,
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: (res) => {
          this.produtos = res;
        },
        error: (res) => {
          console.log(res);
        },
      });
    },
  },
  created() {
    this.getProdutos();
  },
};
</script>


<style scoped>
::v-deep .modal-backdrop {
  opacity: 0.5 !important;
}
::v-deep .vue-notification {
  font-size: 15px !important;
}
</style>
