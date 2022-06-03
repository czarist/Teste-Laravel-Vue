"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[352],{7510:(e,o,t)=>{t.d(o,{Z:()=>n});var a=t(1519),r=t.n(a)()((function(e){return e[1]}));r.push([e.id,"[data-v-1a98764c] .modal-backdrop{opacity:.5!important}[data-v-1a98764c] .vue-notification{font-size:15px!important}",""]);const n=r},7352:(e,o,t)=>{t.r(o),t.d(o,{default:()=>p});var a=t(7757),r=t.n(a),n=t(2063);t(296);function i(e,o,t,a,r,n,i){try{var s=e[n](i),d=s.value}catch(e){return void t(e)}s.done?o(d):Promise.resolve(d).then(a,r)}function s(e){return function(){var o=this,t=arguments;return new Promise((function(a,r){var n=e.apply(o,t);function s(e){i(n,a,r,s,d,"next",e)}function d(e){i(n,a,r,s,d,"throw",e)}s(void 0)}))}}const d={props:["selectedPagar","id"],mixins:[n.Z],data:function(){return{loading:!1,url:"https://www.homolog.intercom.org.br",produtos:[],amount:null,form:{metodo:null,numCartao:null,validade:null,cvv:null,bandeira:null,produto:null,enderecos:{id:null,cep:null,estado:null,municipio:{id:null,nome:null},pais:null,logradouro:null}}}},watch:{selectedPagar:function(){this.selectedPagar&&(this.form.metodo="credito",this.form._method="post",this.form.id=this.selectedPagar.id,this.form.name=this.selectedPagar.name,this.form.email=this.selectedPagar.email,this.form.cpf=this.selectedPagar.cpf,this.form.rg=this.selectedPagar.rg,this.form.orgao_expedidor=this.selectedPagar.orgao_expedidor,this.form.estrangeiro=this.selectedPagar.estrangeiro,this.form.passaporte=this.selectedPagar.passaporte,this.form.data_nascimento=this.selectedPagar.data_nascimento,this.form.sexo_id=this.selectedPagar.sexo_id,this.form.celular=this.selectedPagar.celular,this.form.telefone=this.selectedPagar.telefone,this.form.enderecos=this.selectedPagar.enderecos,this.form.instituicao_id=this.selectedPagar.instituicao_id,this.form.titulacao_id=this.selectedPagar.titulacao_id,this.form.associado=this.selectedPagar.associado,this.form.ativo=this.selectedPagar.ativo,this.form.valorParcela=this.produtos.find((function(e){return 2==e.id})).valor,this.form.parcelas=1),1==this.form.associado&&(this.amount=this.produtos.find((function(e){return 1==e.id})).valor,this.form.produto=this.produtos.find((function(e){return 1==e.id}))),this.listarMeiosPag()},numCartao:function(){this.form.numCartao&&validarBanderia()}},computed:{hasCredito:function(){return null!=this.form.numCartao}},methods:{recarregar:function(){window.location.reload()},redirecionar:function(){window.location.href="/pagamento"},getEstados:function(){var e=this;return s(r().mark((function o(){return r().wrap((function(o){for(;;)switch(o.prev=o.next){case 0:return o.next=2,$.ajax({method:"GET",url:"get/estados",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},dataType:"json",success:function(o){e.estados=o},error:function(e){console.log(e)}});case 2:case"end":return o.stop()}}),o)})))()},listarMeiosPag:function(){var e=this;return s(r().mark((function o(){return r().wrap((function(o){for(;;)switch(o.prev=o.next){case 0:PagSeguroDirectPayment.getPaymentMethods({amount:e.amount,success:function(e){$.each(e.paymentMethods.CREDIT_CARD.options,(function(e,o){$(".meio-pag-credito").append("<span class='img-band'><img src='https://stc.pagseguro.uol.com.br"+o.images.MEDIUM.path+"'></span>")})),$(".meio-pag-boleto").append("<span  class='img-band'><img width='150' height='80' src='https://stc.pagseguro.uol.com.br"+e.paymentMethods.BOLETO.options.BOLETO.images.MEDIUM.path+"'><span>")},error:function(e){},complete:function(e){}});case 1:case"end":return o.stop()}}),o)})))()},validarBanderia:function(){var e=this.form.numCartao.substr(0,7);e=e.replace(/\-/g,""),PagSeguroDirectPayment.getBrand({cardBin:e,success:function(e){var o=e.brand.name;$(".bandeira-cartao").html("<img src='https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/"+o+".png'>"),$(".cartao-nome").html(o),$("#cartao-bandeira").removeClass("hidden"),$(".cartao-nome").removeClass("hidden"),$("#retorno_erro").addClass("hidden"),$("#submit_button").prop("disabled",!1),$("#submit_button_boleto").prop("disabled",!1)},error:function(e){$("#retorno_erro").removeClass("hidden"),$("#retorno_texto").html("Número do cartão invalido, por favor verifique e tente novamente."),$("#submit_button").prop("disabled",!0),$("#submit_button_boleto").prop("disabled",!0)}});var o=document.getElementById("cartao-nome").innerText;this.form.bandeira=o,this.recupParcelas(o)},recupParcelas:function(e){var o=$("#noIntInstalQuantity").val();PagSeguroDirectPayment.getInstallments({amount:this.amount,maxInstallmentNoInterest:o,brand:e,success:function(e){$.each(e.installments,(function(e,o){$.each(o,(function(e,o){var t=o.installmentAmount.toFixed(2).replace(".",","),a=o.installmentAmount.toFixed(2);$("#qntParcelas").show().append("<option value='"+o.quantity+"' data-parcelas='"+a+"'>"+o.quantity+" parcelas de R$ "+t+"</option>")}))}))},error:function(e){$("#retorno_erro").removeClass("hidden"),$("#retorno_texto").html("O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente <br> Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos"),$("#submit_button").prop("disabled",!0),$("#submit_button_boleto").prop("disabled",!0)},complete:function(e){}})},pagarCredito:function(){var e=this;return s(r().mark((function o(){return r().wrap((function(o){for(;;)switch(o.prev=o.next){case 0:return e.loading=!0,o.next=3,e.$validator.validateAll().then((function(o){if(o){e.message("Aguarde...","Estamos processando seu pagamento","info");var t=e.form.numCartao.replace(/\-/g,""),a=document.getElementById("cartao-nome").innerText,r=e.form.validade.split("/"),n=r[0],i=20+r[1],s=e.form.cvv;PagSeguroDirectPayment.createCardToken({cardNumber:t,brand:a,cvv:s,expirationMonth:n,expirationYear:i,success:function(e){var o;o=e.card.token,PagSeguroDirectPayment.onSenderHashReady((function(e){if("error"==e.status)return $("#retorno_erro").removeClass("hidden"),$("#retorno_texto").html("O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente <br> Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos"),$("#submit_button").prop("disabled",!0),$("#submit_button_boleto").prop("disabled",!0),!1;var t=e.senderHash,a=$("#qntParcelas").find(":selected").attr("data-parcelas"),r=$("#qntParcelas").find(":selected").val(),n=document.getElementById("cartao-nome").innerText,i=$("#formPagamentoCartaoCredito").serializeArray();i.push({name:"hashCartao",value:t}),i.push({name:"tokenCartao",value:o}),i.push({name:"valorParcela",value:a}),i.push({name:"parcelas",value:r}),i.push({name:"cardname",value:n}),$.ajax({method:"POST",url:"pagseguro/associado/credito",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},data:$.param(i),dataType:"json",success:function(e){if("error"==e.message){var o="";e.response.error&&e.response.error.forEach((function(e){53012==e.code&&(o+="E-mail enviado para o pagseguro não foi aceito, entre no seu perfil e atualize seu e-mail <br>"),53015==e.code&&(o+="Nome enviado para o pagseguro não foi aceito, entre no seu perfil e atualize seu nome completo <br>"),5003==e.code&&(o+="Falha de comunicação com a instituição financeira, atualize a pagina e tente novamente <br>"),1e4==e.code&&(o+="Marca de cartão de crédito inválida <br>"),10001==e.code&&(o+="Número do cartão de crédito com comprimento inválido <br>"),10002==e.code&&(o+="Formato da data inválida, entre no seu perfil e atualize sua data de nascimento <br>"),10003==e.code&&(o+="Campo de segurança CVV inválido, atualize a pagina e tente novamente <br>"),10004==e.code&&(o+="Código de verificação CVV é obrigatório, atualize a pagina e tente novamente <br>"),10006==e.code&&(o+="Campo de segurança com comprimento inválido, atualize a pagina e tente novamente <br>"),53010==e.code&&(o+="O e-mail do remetente é obrigatório, entre no seu perfil e atualize seu e-mail <br>"),53011==e.code&&(o+="Email do remetente com comprimento inválido, entre no seu perfil e atualize seu e-mail <br>"),53013==e.code&&(o+="O nome do remetente é obrigatório, entre no seu perfil e atualize seu nome <br>"),53014==e.code&&(o+="Nome do remetente está com comprimento inválido, entre no seu perfil e atualize seu nome <br>"),53017==e.code&&(o+="Foi detectado algum erro nos dados do seu CPF, entre em contato com suporte <br>"),53018==e.code&&(o+="O código de área do remetente é obrigatório, entre no seu perfil e atualize seu telefone e celular <br>"),53019==e.code&&(o+="Há um conflito com o código de área informado, em relação a outros dados seus. Entre no seu perfil e atualize seu telefone e celular <br>"),53020==e.code&&(o+="É necessário um telefone do remetente. Entre no seu perfil e atualize seu telefone e celular <br>"),53021==e.code&&(o+="Valor inválido do telefone do remetente. Entre no seu perfil e atualize seu telefone e celular <br>"),53022==e.code&&(o+="É necessário o código postal do endereço de entrega. Entre no seu perfil e atualize seu endereço <br>"),53023==e.code&&(o+="Código postal está com valor inválido. Entre no seu perfil e atualize seu endereço <br>"),53037==e.code&&(o+="O token do cartão de crédito é necessário. atualize a pagina e tente novamente <br>"),53042==e.code&&(o+="O nome do titular do cartão de crédito é obrigatório. Entre no seu perfil e atualize seu Nome Completo <br>"),53043==e.code&&(o+="Nome do titular do cartão de crédito está com o comprimento inválido. Entre no seu perfil e atualize seu Nome Completo <br>"),53044==e.code&&(o+="O nome completo não é valido e não foi aceito pelo pagseguro. Entre no seu perfil e atualize seu Nome Completo <br>"),53045==e.code&&(o+="O CPF do titular do cartão de crédito é obrigatório. Entre em contato com o suporte <br>"),53046==e.code&&(o+="O CPF do titular do cartão de crédito está com valor inválido. Entre em contato com o suporte <br>"),53047==e.code&&(o+="A data de nascimento do titular do cartão de crédito é necessária. Entre no seu perfil e atualize sua data de nascimento <br>"),53048==e.code&&(o+="A data de nascimento do Titular do cartão de crédito está com valor inválido. Entre no seu perfil e atualize sua data de nascimento <br>"),53049==e.code&&(o+="O código de área do titular do cartão de crédito é obrigatório. Entre no seu perfil e atualize seu telefone e celular <br>"),53051==e.code&&(o+="O telefone do titular do cartão de crédito é obrigatório. Entre no seu perfil e atualize seu telefone e celular <br>"),53052==e.code&&(o+="O número de Telefone do titular do cartão de crédito está com valor inválido. Entre no seu perfil e atualize seu telefone e celular <br>"),53053==e.code&&(o+="É necessário o código postal do endereço de cobrança. Entre no seu perfil e atualize seu endereço <br>"),53054==e.code&&(o+="O código postal do endereço de cobrança está com valor inválido. Entre no seu perfil e atualize seu endereço <br>"),53055==e.code&&(o+="O endereço de cobrança é obrigatório. Entre no seu perfil e atualize seu endereço <br>"),53056==e.code&&(o+="A rua, no endereço de cobrança está com comprimento inválido. Entre no seu perfil e atualize seu endereço <br>"),53057==e.code&&(o+="É necessário o número no endereço de cobrança. Entre no seu perfil e atualize seu endereço <br>"),53058==e.code&&(o+="Número de endereço de cobrança está com comprimento inválido. Entre no seu perfil e atualize seu endereço <br>"),53059==e.code&&(o+="Endereço de cobrança complementar está com comprimento inválido. Entre no seu perfil e atualize seu endereço <br>"),53060==e.code&&(o+="O endereço de cobrança é obrigatório. Entre no seu perfil e atualize seu endereço <br>"),53061==e.code&&(o+="O endereço de cobrança está com tamanho inválido. Entre no seu perfil e atualize seu endereço <br>"),53062==e.code&&(o+="É necessário informar a cidade no endereço de cobrança. Entre no seu perfil e atualize seu endereço <br>"),53063==e.code&&(o+="O item Cidade, está com o comprimento inválido no endereço de cobrança. Entre no seu perfil e atualize seu endereço <br>"),53064==e.code&&(o+="O estado, no endereço de cobrança é obrigatório. Entre no seu perfil e atualize seu endereço <br>"),53065==e.code&&(o+="No endereço de cobrança, o estado está com algum valor inválido. Entre no seu perfil e atualize seu endereço <br>"),53066==e.code&&(o+="O endereço de cobrança do país é obrigatório. Entre no seu perfil e atualize seu endereço <br>"),53067==e.code&&(o+="No endereço de cobrança, o país está com um comprimento inválido. Entre no seu perfil e atualize seu endereço <br>"),53068==e.code&&(o+="O email do destinatário está com tamanho inválido. Entre no seu perfil e atualize seu email <br>"),53069==e.code&&(o+="Valor inválido do e-mail do destinatário. Entre no seu perfil e atualize seu email <br>"),53085==e.code&&(o+="Método de pagamento indisponível. Entre em contato com suporte <br>"),53087==e.code&&(o+="Método de pagamento indisponível. Entre em contato com suporte <br>"),53091==e.code&&(o+="O Hash do remetente está inválido. Atualize sua pagina e tente novamente <br>"),53092==e.code&&(o+="A Bandeira do cartão de crédito não é aceita. Atualize sua pagina e tente com outro cartão <br>"),53105==e.code&&(o+="As informações do remetente foram fornecidas, portanto o e-mail também deve ser informado. Entre no seu perfil e atualize o seu email <br>"),53106==e.code&&(o+="O titular do cartão de crédito está incompleto. Entre no seu perfil e atualize o seu nome completo <br>"),53110==e.code&&(o+="Banco EFT é obrigatório, tente com outro cartão <br>"),53111==e.code&&(o+="Banco EFT não é aceito, tente com outro cartão <br>"),53115==e.code&&(o+="Valor inválido da data de nascimento do remetente, entre no seu perfil e atualize sua data de nascimento<br>"),53122==e.code&&(o+="Erro entre em contato com o suporte, erro 53122 <br>"),53141==e.code&&(o+="Erro entre em contato com o suporte, erro 53141 <br>"),53142==e.code&&(o+="O cartão de crédito está com o token inválido, atualize a pagina e tente novamente <br>")})),$("#retorno_erro").removeClass("hidden"),""==o&&(o+="Erro ao processar o pagamento, caso não tenha recebido nenhum informativo de erro acima entre em contato com o suporte, email: suporte@kirc.com.br ou whatsapp (11) 96365-1888 <br>"),$("#retorno_texto").html(o),$("#submit_button").prop("disabled",!0),$("#submit_button_boleto").prop("disabled",!0),setTimeout((function(){window.location.href="/pagamento?status=error"}),1e4)}else $("#redirecionar_botao").removeClass("hidden").attr("class","text-center"),$("#retorno_ok").removeClass("hidden"),$("#retorno_titulo_ok").html("Sucesso!"),$("#retorno_texto_ok").html("Seu pagamento foi processado com sucesso"),$("#submit_button").prop("disabled",!0),$("#submit_button_boleto").prop("disabled",!0),setTimeout((function(){window.location.href="/pagamento?status=sucess"}),1e4)},error:function(e){$("#retorno_erro").removeClass("hidden"),$("#retorno_texto").html("O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente <br> Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos"),$("#submit_button").prop("disabled",!0),$("#submit_button_boleto").prop("disabled",!0)}})}))},error:function(e){$("#retorno_erro").removeClass("hidden"),$("#retorno_texto").html("O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente <br> Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos"),$("#submit_button").prop("disabled",!0),$("#submit_button_boleto").prop("disabled",!0)},complete:function(e){}})}else e.loading=!1,e.message("Campos Obrigatórios","Preencha todos os campos obrigatórios","error")}));case 3:case"end":return o.stop()}}),o)})))()},pagarBoleto:function(){var e=this;return s(r().mark((function o(){return r().wrap((function(o){for(;;)switch(o.prev=o.next){case 0:return e.loading=!0,o.next=3,PagSeguroDirectPayment.onSenderHashReady((function(o){if("error"==o.status)return e.loading=!1,!1;e.form.hashBoleto=o.senderHash,e.form.metodo="boleto",e.$validator.validateAll().then((function(o){o?(e.message("Aguarde...","Estamos processando seu pagamento","info"),setTimeout((function(){var o=e.form;$.ajax({method:"POST",url:"pagseguro/associado/boleto",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},data:$.param(o),dataType:"json",success:function(o){if("error"==o.message){var t="";o.response.error&&o.response.error.forEach((function(e){53012==e.code&&(t+="E-mail enviado para o pagseguro não foi aceito, entre no seu perfil e atualize seu e-mail <br>"),53015==e.code&&(t+="Nome enviado para o pagseguro não foi aceito, entre no seu perfil e atualize seu nome completo <br>"),5003==e.code&&(t+="Falha de comunicação com a instituição financeira, atualize a pagina e tente novamente <br>"),1e4==e.code&&(t+="Marca de cartão de crédito inválida <br>"),10001==e.code&&(t+="Número do cartão de crédito com comprimento inválido <br>"),10002==e.code&&(t+="Formato da data inválida, entre no seu perfil e atualize sua data de nascimento <br>"),10003==e.code&&(t+="Campo de segurança CVV inválido, atualize a pagina e tente novamente <br>"),10004==e.code&&(t+="Código de verificação CVV é obrigatório, atualize a pagina e tente novamente <br>"),10006==e.code&&(t+="Campo de segurança com comprimento inválido, atualize a pagina e tente novamente <br>"),53010==e.code&&(t+="O e-mail do remetente é obrigatório, entre no seu perfil e atualize seu e-mail <br>"),53011==e.code&&(t+="Email do remetente com comprimento inválido, entre no seu perfil e atualize seu e-mail <br>"),53013==e.code&&(t+="O nome do remetente é obrigatório, entre no seu perfil e atualize seu nome <br>"),53014==e.code&&(t+="Nome do remetente está com comprimento inválido, entre no seu perfil e atualize seu nome <br>"),53017==e.code&&(t+="Foi detectado algum erro nos dados do seu CPF, entre em contato com suporte <br>"),53018==e.code&&(t+="O código de área do remetente é obrigatório, entre no seu perfil e atualize seu telefone e celular <br>"),53019==e.code&&(t+="Há um conflito com o código de área informado, em relação a outros dados seus. Entre no seu perfil e atualize seu telefone e celular <br>"),53020==e.code&&(t+="É necessário um telefone do remetente. Entre no seu perfil e atualize seu telefone e celular <br>"),53021==e.code&&(t+="Valor inválido do telefone do remetente. Entre no seu perfil e atualize seu telefone e celular <br>"),53022==e.code&&(t+="É necessário o código postal do endereço de entrega. Entre no seu perfil e atualize seu endereço <br>"),53023==e.code&&(t+="Código postal está com valor inválido. Entre no seu perfil e atualize seu endereço <br>"),53037==e.code&&(t+="O token do cartão de crédito é necessário. atualize a pagina e tente novamente <br>"),53042==e.code&&(t+="O nome do titular do cartão de crédito é obrigatório. Entre no seu perfil e atualize seu Nome Completo <br>"),53043==e.code&&(t+="Nome do titular do cartão de crédito está com o comprimento inválido. Entre no seu perfil e atualize seu Nome Completo <br>"),53044==e.code&&(t+="O nome completo não é valido e não foi aceito pelo pagseguro. Entre no seu perfil e atualize seu Nome Completo <br>"),53045==e.code&&(t+="O CPF do titular do cartão de crédito é obrigatório. Entre em contato com o suporte <br>"),53046==e.code&&(t+="O CPF do titular do cartão de crédito está com valor inválido. Entre em contato com o suporte <br>"),53047==e.code&&(t+="A data de nascimento do titular do cartão de crédito é necessária. Entre no seu perfil e atualize sua data de nascimento <br>"),53048==e.code&&(t+="A data de nascimento do Titular do cartão de crédito está com valor inválido. Entre no seu perfil e atualize sua data de nascimento <br>"),53049==e.code&&(t+="O código de área do titular do cartão de crédito é obrigatório. Entre no seu perfil e atualize seu telefone e celular <br>"),53051==e.code&&(t+="O telefone do titular do cartão de crédito é obrigatório. Entre no seu perfil e atualize seu telefone e celular <br>"),53052==e.code&&(t+="O número de Telefone do titular do cartão de crédito está com valor inválido. Entre no seu perfil e atualize seu telefone e celular <br>"),53053==e.code&&(t+="É necessário o código postal do endereço de cobrança. Entre no seu perfil e atualize seu endereço <br>"),53054==e.code&&(t+="O código postal do endereço de cobrança está com valor inválido. Entre no seu perfil e atualize seu endereço <br>"),53055==e.code&&(t+="O endereço de cobrança é obrigatório. Entre no seu perfil e atualize seu endereço <br>"),53056==e.code&&(t+="A rua, no endereço de cobrança está com comprimento inválido. Entre no seu perfil e atualize seu endereço <br>"),53057==e.code&&(t+="É necessário o número no endereço de cobrança. Entre no seu perfil e atualize seu endereço <br>"),53058==e.code&&(t+="Número de endereço de cobrança está com comprimento inválido. Entre no seu perfil e atualize seu endereço <br>"),53059==e.code&&(t+="Endereço de cobrança complementar está com comprimento inválido. Entre no seu perfil e atualize seu endereço <br>"),53060==e.code&&(t+="O endereço de cobrança é obrigatório. Entre no seu perfil e atualize seu endereço <br>"),53061==e.code&&(t+="O endereço de cobrança está com tamanho inválido. Entre no seu perfil e atualize seu endereço <br>"),53062==e.code&&(t+="É necessário informar a cidade no endereço de cobrança. Entre no seu perfil e atualize seu endereço <br>"),53063==e.code&&(t+="O item Cidade, está com o comprimento inválido no endereço de cobrança. Entre no seu perfil e atualize seu endereço <br>"),53064==e.code&&(t+="O estado, no endereço de cobrança é obrigatório. Entre no seu perfil e atualize seu endereço <br>"),53065==e.code&&(t+="No endereço de cobrança, o estado está com algum valor inválido. Entre no seu perfil e atualize seu endereço <br>"),53066==e.code&&(t+="O endereço de cobrança do país é obrigatório. Entre no seu perfil e atualize seu endereço <br>"),53067==e.code&&(t+="No endereço de cobrança, o país está com um comprimento inválido. Entre no seu perfil e atualize seu endereço <br>"),53068==e.code&&(t+="O email do destinatário está com tamanho inválido. Entre no seu perfil e atualize seu email <br>"),53069==e.code&&(t+="Valor inválido do e-mail do destinatário. Entre no seu perfil e atualize seu email <br>"),53085==e.code&&(t+="Método de pagamento indisponível. Entre em contato com suporte <br>"),53087==e.code&&(t+="Método de pagamento indisponível. Entre em contato com suporte <br>"),53091==e.code&&(t+="O Hash do remetente está inválido. Atualize sua pagina e tente novamente <br>"),53092==e.code&&(t+="A Bandeira do cartão de crédito não é aceita. Atualize sua pagina e tente com outro cartão <br>"),53105==e.code&&(t+="As informações do remetente foram fornecidas, portanto o e-mail também deve ser informado. Entre no seu perfil e atualize o seu email <br>"),53106==e.code&&(t+="O titular do cartão de crédito está incompleto. Entre no seu perfil e atualize o seu nome completo <br>"),53110==e.code&&(t+="Banco EFT é obrigatório, tente com outro cartão <br>"),53111==e.code&&(t+="Banco EFT não é aceito, tente com outro cartão <br>"),53115==e.code&&(t+="Valor inválido da data de nascimento do remetente, entre no seu perfil e atualize sua data de nascimento<br>"),53122==e.code&&(t+="Erro entre em contato com o suporte, erro 53122 <br>"),53141==e.code&&(t+="Erro entre em contato com o suporte, erro 53141 <br>"),53142==e.code&&(t+="O cartão de crédito está com o token inválido, atualize a pagina e tente novamente <br>")})),""==t&&(t+="Erro ao processar o pagamento, caso não tenha recebido nenhum informativo de erro acima entre em contato com o suporte, email: suporte@kirc.com.br ou whatsapp (11) 96365-1888 <br>"),$("#retorno_erro1").removeClass("hidden"),$("#retorno_texto1").html(t),$("#submit_button").prop("disabled",!0),$("#submit_button_boleto").prop("disabled",!0),setTimeout((function(){window.location.href="/pagamento?status=error"}),1e4)}else e.message("Sucesso","Seu pagamento foi processado com sucesso","success"),e.loading=!1,window.open(o.response.paymentLink,"_blank")},error:function(o){if(422==o.response.status&&"The given data was invalid."==o.response.data.message)return e.loading=!1,e.message("Erro","Erro ao processar o pagamento, O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente. Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos","error");500==o.response.status&&(e.loading=!1,e.message("Erro","Erro ao processar o pagamento, O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente. Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos.","error")),403==o.response.status&&"This action is unauthorized."==o.response.data.message&&(e.loading=!1,e.message("Erro","Ação não autorizada.","error"))}})}),1e3)):(e.loading=!1,e.message("Erro","Erro ao processar o pagamento, O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente. Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos","error"))}))}));case 3:case"end":return o.stop()}}),o)})))()},getProdutos:function(){var e=this;return s(r().mark((function o(){return r().wrap((function(o){for(;;)switch(o.prev=o.next){case 0:return o.next=2,$.ajax({method:"GET",url:"get/produtos",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},dataType:"json",success:function(o){e.produtos=o},error:function(e){console.log(e)}});case 2:case"end":return o.stop()}}),o)})))()}},created:function(){this.getProdutos()}};var c=t(3379),l=t.n(c),u=t(7510),m={insert:"head",singleton:!1};l()(u.Z,m);u.Z.locals;const p=(0,t(1900).Z)(d,(function(){var e=this,o=e.$createElement,t=e._self._c||o;return t("b-modal",{attrs:{id:"pagar",size:"xl"},scopedSlots:e._u([{key:"modal-header",fn:function(o){var a=o.close;return[t("div",{staticClass:"text-center"},[t("p",{staticStyle:{"font-size":"18px !important","text-align":"center !important"}},[e._v("Escolha uma forma de Pagamento")])]),e._v(" "),t("b-button",{attrs:{size:"sm",variant:"outline-danger"},on:{click:function(e){return a()}}},[e._v("x")])]}},{key:"modal-footer",fn:function(o){var a=o.cancel;return[t("div",{staticClass:"hidden",attrs:{id:"redirecionar_botao"}},[t("b-button",{attrs:{size:"xl",variant:"outline-success",disabled:e.loading},on:{click:function(o){return e.redirecionar()}}},[e._v("\n                Área de Pagamentos\n            ")])],1),e._v(" "),t("b-button",{attrs:{size:"md",variant:"outline-danger",disabled:e.loading},on:{click:function(e){return a()}}},[e._v("\n            Cancelar\n        ")]),e._v(" "),e.hasCredito?t("b-button",{attrs:{id:"submit_button",disabled:e.loading,size:"md",variant:"outline-success"},on:{click:function(o){return e.pagarCredito()}}},[e._v("Pagar\n        ")]):t("b-button",{attrs:{disabled:e.loading,size:"md",variant:"outline-success",id:"submit_button_boleto"},on:{click:function(o){return e.pagarBoleto()}}},[e._v("Gerar Boleto\n        ")])]}}])},[e._v(" "),[t("div",[t("b-card",{attrs:{"no-body":""}},[t("b-tabs",{attrs:{card:""}},[t("b-tab",{attrs:{title:"Cartão de Crédito",active:""}},[t("b-card-text",[t("div",{staticClass:"container"},[t("div",{staticClass:"section-head style-3 text-center z mb-3"},[t("h2",{staticClass:"title"},[e._v("Checkout "),t("img",{attrs:{src:e.url+"/images/pagseguro.png"}})]),e._v(" "),t("p",[e._v("Preencha os dados para finalizar o pagamento")])])]),e._v(" "),t("div",{staticClass:"container hidden",attrs:{id:"retorno_ok"}},[t("div",{staticClass:"section-head style-3 text-center z mb-3 alert alert-success",attrs:{role:"alert"}},[t("h2",{staticClass:"title",attrs:{id:"retorno_titulo_ok"}}),e._v(" "),t("p",{attrs:{id:"retorno_texto_ok"}})])]),e._v(" "),t("div",{staticClass:"container hidden",attrs:{id:"retorno_erro"}},[t("div",{staticClass:"section-head style-3 text-center z mb-3 alert alert-danger",attrs:{role:"alert"}},[t("h2",{staticClass:"title",attrs:{id:"retorno_titulo"}}),e._v(" "),t("p",{attrs:{id:"retorno_texto"}}),e._v(" "),t("div",[t("b-button",{attrs:{size:"xl",variant:"outline-danger"},on:{click:function(o){return e.recarregar()}}},[e._v("\n                                        Voltar\n                                    ")])],1)])]),e._v(" "),t("div",{staticClass:"container"},[t("b-row",[t("b-col",{attrs:{cols:"12",sm:"6",lg:"6"}},[t("b-form-group",{attrs:{label:"Número do Cartão","label-class":"font-weight-bold"}},[t("b-form-input",{directives:[{name:"validate",rawName:"v-validate",value:{required:!0},expression:"{ required: true }"},{name:"mask",rawName:"v-mask",value:"####-####-####-####",expression:"'####-####-####-####'"}],class:["form-control form-control-sm",{"is-invalid":e.errors.has("numCartao")}],attrs:{name:"numCartao",size:"sm",type:"text",disabled:e.loading,"aria-describedby":"input-1-live-feedback","data-vv-as":"Número do Cartão"},on:{change:function(o){return e.validarBanderia()}},model:{value:e.form.numCartao,callback:function(o){e.$set(e.form,"numCartao",o)},expression:"form.numCartao"}}),e._v(" "),t("span",{directives:[{name:"show",rawName:"v-show",value:e.errors.has("numCartao"),expression:"errors.has(`numCartao`)"}],staticClass:"invalid-feedback"},[e._v("\n                                            "+e._s(e.errors.first("numCartao"))+"\n                                        ")]),e._v(" "),t("div",{staticClass:"container"},[t("div",{staticClass:"row"},[t("span",{staticClass:"col-6 input-group-text bandeira-cartao creditCard hidden",staticStyle:{"background-color":"#ffffff"},attrs:{id:"cartao-bandeira"}}),e._v(" "),t("span",{staticClass:"col-6 input-group-text cartao-nome creditCard form-login-help hidden",staticStyle:{"background-color":"#ffffff"},attrs:{type:"text",id:"cartao-nome"}})])])],1)],1),e._v(" "),t("b-col",{attrs:{cols:"12",sm:"6",lg:"6"}},[t("b-form-group",{attrs:{label:"Validade","label-class":"font-weight-bold"}},[t("b-form-input",{directives:[{name:"validate",rawName:"v-validate",value:{required:!0},expression:"{ required: true }"},{name:"mask",rawName:"v-mask",value:"##/##",expression:"'##/##'"}],class:["form-control form-control-sm",{"is-invalid":e.errors.has("validade")}],attrs:{name:"validade",size:"sm",type:"text",disabled:e.loading,"aria-describedby":"input-1-live-feedback","data-vv-as":"Validade"},model:{value:e.form.validade,callback:function(o){e.$set(e.form,"validade",o)},expression:"form.validade"}}),e._v(" "),t("span",{staticClass:"invalid-feedback",staticStyle:{"font-size":"12px !important"}},[e._v("\n                                            Ex: Formato da validade é 20/22\n                                        ")]),e._v(" "),t("span",{directives:[{name:"show",rawName:"v-show",value:e.errors.has("validade"),expression:"errors.has(`validade`)"}],staticClass:"invalid-feedback"},[e._v("\n                                            "+e._s(e.errors.first("validade"))+"\n                                        ")])],1)],1),e._v(" "),t("b-col",{attrs:{cols:"12",sm:"6",lg:"6"}},[t("b-form-group",{attrs:{label:"Código de Segurança","label-class":"font-weight-bold"}},[t("b-form-input",{directives:[{name:"validate",rawName:"v-validate",value:{required:!0},expression:"{ required: true }"},{name:"mask",rawName:"v-mask",value:"####",expression:"'####'"}],class:["form-control form-control-sm",{"is-invalid":e.errors.has("cvv")}],attrs:{name:"cvv",size:"sm",type:"text",disabled:e.loading,"aria-describedby":"input-1-live-feedback","data-vv-as":"Código de Segurança"},model:{value:e.form.cvv,callback:function(o){e.$set(e.form,"cvv",o)},expression:"form.cvv"}}),e._v(" "),t("span",{directives:[{name:"show",rawName:"v-show",value:e.errors.has("cvv"),expression:"errors.has(`cvv`)"}],staticClass:"invalid-feedback"},[e._v("\n                                            "+e._s(e.errors.first("cvv"))+"\n                                        ")])],1)],1),e._v(" "),t("b-col",{attrs:{cols:"12",sm:"6",lg:"6"}},[t("b-form-group",{attrs:{label:"Quantidade de Parcelas","label-class":"font-weight-bold"}},[t("b-form-select",{directives:[{name:"validate",rawName:"v-validate",value:{required:!0},expression:"{ required: true }"}],staticClass:"form-control form-control-sm",class:["form-control form-control-sm",{"is-invalid":e.errors.has("qntParcelas")}],attrs:{disabled:!0,name:"qntParcelas",id:"qntParcelas",size:"sm","data-vv-as":"Quantidade de Parcelas"},model:{value:e.form.qntParcelas,callback:function(o){e.$set(e.form,"qntParcelas",o)},expression:"form.qntParcelas"}}),e._v(" "),t("span",{directives:[{name:"show",rawName:"v-show",value:e.errors.has("qntParcelas"),expression:"errors.has(`qntParcelas`)"}],staticClass:"invalid-feedback"},[e._v("\n                                            "+e._s(e.errors.first("qntParcelas"))+"\n                                        ")])],1)],1)],1),e._v(" "),t("div",{staticClass:"meio-pag-credito",staticStyle:{"padding-top":"10px","padding-bottom":"20px"},attrs:{id:"meio-pag-credito",name:"meio-pag-credito",align:"center"}}),e._v(" "),t("div",{staticClass:"hidden"},[t("form",{attrs:{method:"post","accept-charset":"utf-8",name:"formPagamentoCartaoCredito",id:"formPagamentoCartaoCredito",action:""}},[t("input",{attrs:{type:"hidden",name:"recupHashCartao",id:"recupHashCartao",value:""}}),e._v(" "),t("input",{attrs:{type:"hidden",name:"numCartao",id:"numCartao"},domProps:{value:e.form.numCartao}}),e._v(" "),t("input",{attrs:{type:"hidden",name:"cvv",id:"cvv"},domProps:{value:e.form.cvv}}),e._v(" "),t("input",{attrs:{type:"hidden",name:"validade",id:"validade"},domProps:{value:e.form.validade}}),e._v(" "),t("input",{attrs:{type:"hidden",name:"associado",id:"associado"},domProps:{value:e.form.associado}}),e._v(" "),t("input",{attrs:{type:"hidden",name:"metodo",id:"metodo"},domProps:{value:e.form.metodo}}),e._v(" "),t("input",{attrs:{type:"hidden",name:"id",id:"id"},domProps:{value:e.form.id}}),e._v(" "),t("input",{attrs:{type:"hidden",name:"ativo",id:"ativo"},domProps:{value:e.form.ativo}}),e._v(" "),t("input",{attrs:{type:"hidden",name:"name",id:"name"},domProps:{value:e.form.name}}),e._v(" "),t("input",{attrs:{type:"hidden",name:"rg",id:"rg"},domProps:{value:e.form.rg}}),e._v(" "),t("input",{attrs:{type:"hidden",name:"orgao_expedidor",id:"orgao_expedidor"},domProps:{value:e.form.orgao_expedidor}}),e._v(" "),t("input",{attrs:{type:"hidden",name:"data_nascimento",id:"data_nascimento"},domProps:{value:e.form.data_nascimento}}),e._v(" "),t("input",{attrs:{type:"hidden",name:"sexo_id",id:"sexo_id"},domProps:{value:e.form.sexo_id}}),e._v(" "),t("input",{attrs:{type:"hidden",name:"telefone",id:"telefone"},domProps:{value:e.form.telefone}}),e._v(" "),t("input",{attrs:{type:"hidden",name:"celular",id:"celular"},domProps:{value:e.form.celular}}),e._v(" "),t("input",{attrs:{type:"hidden",name:"titulacao_id",id:"titulacao_id"},domProps:{value:e.form.titulacao_id}}),e._v(" "),t("input",{attrs:{type:"hidden",name:"instituicao_id",id:"instituicao_id"},domProps:{value:e.form.instituicao_id}}),e._v(" "),t("input",{attrs:{type:"hidden",name:"enderecoId",id:"enderecoId"},domProps:{value:e.form.enderecos.id}}),e._v(" "),t("input",{attrs:{type:"hidden",name:"cep",id:"cep"},domProps:{value:e.form.enderecos.cep}}),e._v(" "),t("input",{attrs:{type:"hidden",name:"estado",id:"estado"},domProps:{value:e.form.enderecos.estado}}),e._v(" "),t("input",{attrs:{type:"hidden",name:"logradouro",id:"logradouro"},domProps:{value:e.form.enderecos.logradouro}}),e._v(" "),t("input",{attrs:{type:"hidden",name:"numero",id:"numero"},domProps:{value:e.form.enderecos.numero}}),e._v(" "),t("input",{attrs:{type:"hidden",name:"bairro",id:"bairro"},domProps:{value:e.form.enderecos.bairro}}),e._v(" "),t("input",{attrs:{type:"hidden",name:"complemento",id:"complemento"},domProps:{value:e.form.enderecos.complemento}}),e._v(" "),t("input",{attrs:{type:"hidden",name:"municipio",id:"municipio"},domProps:{value:e.form.enderecos.municipio.id}}),e._v(" "),t("input",{attrs:{type:"hidden",name:"pais",id:"pais"},domProps:{value:e.form.pais}})])])],1)])],1),e._v(" "),t("b-tab",{attrs:{title:"Boleto"}},[t("b-card-text",[t("div",{staticClass:"container hidden",attrs:{id:"retorno_ok1"}},[t("div",{staticClass:"section-head style-3 text-center z mb-3 alert alert-success",attrs:{role:"alert"}},[t("h2",{staticClass:"title",attrs:{id:"retorno_titulo_ok"}}),e._v(" "),t("p",{attrs:{id:"retorno_texto_ok1"}})])]),e._v(" "),t("div",{staticClass:"container hidden",attrs:{id:"retorno_erro1"}},[t("div",{staticClass:"section-head style-3 text-center z mb-3 alert alert-danger ",attrs:{role:"alert"}},[t("h2",{staticClass:"title",attrs:{id:"retorno_titulo1"}}),e._v(" "),t("p",{attrs:{id:"retorno_texto1"}}),e._v(" "),t("div",[t("b-button",{attrs:{size:"xl",variant:"outline-danger"},on:{click:function(o){return e.recarregar()}}},[e._v("\n                                    Voltar\n                                ")])],1)])]),e._v(" "),t("form",{staticClass:"form-horizontal",attrs:{action:"",method:"post","accept-charset":"utf-8",name:"formPagamentoBoleto",id:"formPagamentoBoleto"}},[t("fieldset",[t("div",{staticClass:"meio-pag-boleto",staticStyle:{"padding-bottom":"20px"},attrs:{align:"center"}})])])]),e._v(" "),t("div",{staticClass:"text-center"},[t("b-button",{attrs:{disabled:e.loading,size:"md",id:"submit_button_boleto",variant:"btn btn-success"},on:{click:function(o){return e.pagarBoleto()}}},[e._v("Gerar Boleto\n                            ")])],1)],1)],1)],1)],1),e._v(" "),t("notifications",{attrs:{group:"submit",position:"center",width:"500px"}})]],2)}),[],!1,null,"1a98764c",null).exports}}]);