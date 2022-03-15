"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[856],{4989:(e,t,a)=>{a.d(t,{Z:()=>s});var o=a(1519),r=a.n(o)()((function(e){return e[1]}));r.push([e.id,"[data-v-24477ee2] .modal-backdrop{opacity:.5!important}[data-v-24477ee2] .vue-notification{font-size:15px!important}",""]);const s=r},5856:(e,t,a)=>{a.r(t),a.d(t,{default:()=>p});var o=a(7757),r=a.n(o),s=a(2063);a(296);function n(e,t,a,o,r,s,n){try{var i=e[s](n),d=i.value}catch(e){return void a(e)}i.done?t(d):Promise.resolve(d).then(o,r)}function i(e){return function(){var t=this,a=arguments;return new Promise((function(o,r){var s=e.apply(t,a);function i(e){n(s,o,r,i,d,"next",e)}function d(e){n(s,o,r,i,d,"throw",e)}i(void 0)}))}}const d={props:["selectedPagar","id"],mixins:[s.Z],data:function(){return{loading:!1,baseUrl:"https://www.sistemas.intercom.org.br",amount:null,regiao:null,form:{metodo:"credito",_method:"post",id:this.selectedPagar?this.selectedPagar.id:null,name:this.selectedPagar?this.selectedPagar.name:null,email:this.selectedPagar?this.selectedPagar.email:null,cpf:this.selectedPagar?this.selectedPagar.cpf:null,rg:this.selectedPagar?this.selectedPagar.rg:null,orgao_expedidor:this.selectedPagar?this.selectedPagar.orgao_expedidor:null,estrangeiro:this.selectedPagar?this.selectedPagar.estrangeiro:null,passaporte:this.selectedPagar?this.selectedPagar.passaporte:null,data_nascimento:this.selectedPagar?this.selectedPagar.data_nascimento:null,sexo_id:this.selectedPagar?this.selectedPagar.sexo_id:null,celular:this.selectedPagar?this.selectedPagar.celular:null,instituicao_id:this.selectedPagar?this.selectedPagar.instituicao_id:null,titulacao_id:this.selectedPagar?this.selectedPagar.titulacao_id:null,anuidade2022:null,ativo:this.selectedPagar?this.selectedPagar.ativo:null,produto:null}}},watch:{selectedPagar:function(){var e=this;this.selectedPagar&&(this.form.metodo="credito",this.form._method="post",this.form.anuidade2022=1,this.form.id=this.selectedPagar.id,this.form.name=this.selectedPagar.name,this.form.email=this.selectedPagar.email,this.form.password=this.selectedPagar.password,this.form.cpf=this.selectedPagar.cpf,this.form.rg=this.selectedPagar.rg,this.form.orgao_expedidor=this.selectedPagar.orgao_expedidor,this.form.estrangeiro=this.selectedPagar.estrangeiro,this.form.passaporte=this.selectedPagar.passaporte,this.form.data_nascimento=this.selectedPagar.data_nascimento,this.form.sexo_id=this.selectedPagar.sexo_id,this.form.celular=this.selectedPagar.celular,this.form.telefone=this.selectedPagar.telefone,this.form.enderecos=this.selectedPagar.enderecos,this.form.instituicao_id=this.selectedPagar.instituicao_id,this.form.titulacao_id=this.selectedPagar.titulacao_id,this.form.associado=this.selectedPagar.associado,this.form.ativo=this.selectedPagar.ativo,this.form.valorParcela=this.produtos.find((function(t){return t.id==e.selectedPagar.taxa_inscricao.id})).valor,this.form.parcelas=1,this.regiao=this.selectedPagar.regiao),1==this.form.anuidade2022&&(this.amount=this.produtos.find((function(t){return t.id==e.selectedPagar.taxa_inscricao.id})).valor,this.form.produto=this.produtos.find((function(t){return t.id==e.selectedPagar.taxa_inscricao.id}))),this.listarMeiosPag()},numCartao:function(){this.form.numCartao&&validarBanderia()}},computed:{hasCredito:function(){return null!=this.form.numCartao}},methods:{recarregar:function(){window.location.reload()},redirecionar:function(){window.location.href="/pagamento"},listarMeiosPag:function(){var e=this;return i(r().mark((function t(){return r().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:PagSeguroDirectPayment.getPaymentMethods({amount:e.amount,success:function(e){$.each(e.paymentMethods.CREDIT_CARD.options,(function(e,t){$(".meio-pag-credito").append("<span class='img-band'><img src='https://stc.pagseguro.uol.com.br"+t.images.MEDIUM.path+"'></span>")})),$(".meio-pag-boleto").append("<span  class='img-band'><img width='150' height='80' src='https://stc.pagseguro.uol.com.br"+e.paymentMethods.BOLETO.options.BOLETO.images.MEDIUM.path+"'><span>")},error:function(e){},complete:function(e){}});case 1:case"end":return t.stop()}}),t)})))()},validarBanderia:function(){var e=this.form.numCartao.substr(0,7);e=e.replace(/\-/g,""),PagSeguroDirectPayment.getBrand({cardBin:e,success:function(e){var t=e.brand.name;$(".bandeira-cartao").html("<img src='https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/"+t+".png'>"),$(".cartao-nome").html(t),$("#cartao-bandeira").removeClass("hidden"),$(".cartao-nome").removeClass("hidden"),$("#retorno_erro").addClass("hidden"),$("#submit_button").prop("disabled",!1),$("#submit_button_boleto").prop("disabled",!1)},error:function(e){$("#retorno_erro").removeClass("hidden"),$("#retorno_texto").html("Número do cartão invalido, por favor verifique e tente novamente."),$("#submit_button").prop("disabled",!0),$("#submit_button_boleto").prop("disabled",!0)}});var t=document.getElementById("cartao-nome").innerText;this.form.bandeira=t,this.recupParcelas(t)},recupParcelas:function(e){var t=$("#noIntInstalQuantity").val();PagSeguroDirectPayment.getInstallments({amount:this.amount,maxInstallmentNoInterest:t,brand:e,success:function(e){$.each(e.installments,(function(e,t){$.each(t,(function(e,t){var a=t.installmentAmount.toFixed(2).replace(".",","),o=t.installmentAmount.toFixed(2);$("#qntParcelas").show().append("<option value='"+t.quantity+"' data-parcelas='"+o+"'>"+t.quantity+" parcelas de R$ "+a+"</option>")}))}))},error:function(e){$("#retorno_erro").removeClass("hidden"),$("#retorno_texto").html("O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente <br> Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos"),$("#submit_button").prop("disabled",!0),$("#submit_button_boleto").prop("disabled",!0)},complete:function(e){}})},pagarCredito:function(){var e=this;return i(r().mark((function t(){return r().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.$validator.validateAll().then((function(t){if(t){e.message("Aguarde...","Estamos processando seu pagamento","info");var a=e.form.numCartao.replace(/\-/g,""),o=document.getElementById("cartao-nome").innerText,r=e.form.validade.split("/"),s=r[0],n=20+r[1],i=e.form.cvv,d=e.baseUrl+"/pagseguro/regionais/credito";PagSeguroDirectPayment.createCardToken({cardNumber:a,brand:o,cvv:i,expirationMonth:s,expirationYear:n,success:function(e){var t;t=e.card.token,PagSeguroDirectPayment.onSenderHashReady((function(e){if("error"==e.status)return $("#retorno_erro").removeClass("hidden"),$("#retorno_texto").html("O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente <br> Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos"),$("#submit_button").prop("disabled",!0),$("#submit_button_boleto").prop("disabled",!0),!1;var a=e.senderHash,o=$("#qntParcelas").find(":selected").attr("data-parcelas"),r=$("#qntParcelas").find(":selected").val(),s=document.getElementById("cartao-nome").innerText,n=$("#formPagamentoCartaoCredito").serializeArray();n.push({name:"hashCartao",value:a}),n.push({name:"tokenCartao",value:t}),n.push({name:"valorParcela",value:o}),n.push({name:"parcelas",value:r}),n.push({name:"cardname",value:s}),$.ajax({method:"POST",url:d,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},data:$.param(n),dataType:"json",success:function(e){"error"==e.message?($("#retorno_erro").removeClass("hidden"),$("#retorno_texto").html("O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente <br> Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos"),$("#submit_button").prop("disabled",!0),$("#submit_button_boleto").prop("disabled",!0),setTimeout((function(){window.location.href="/pagamento?status=error"}),2e3)):($("#redirecionar_botao").removeClass("hidden").attr("class","text-center"),$("#retorno_ok").removeClass("hidden"),$("#retorno_titulo_ok").html("Sucesso!"),$("#retorno_texto_ok").html("Seu pagamento foi processado com sucesso"),$("#submit_button").prop("disabled",!0),$("#submit_button_boleto").prop("disabled",!0),setTimeout((function(){window.location.href="/pagamento?status=sucess"}),2e3))},error:function(e){$("#retorno_erro").removeClass("hidden"),$("#retorno_texto").html("O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente <br> Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos"),$("#submit_button").prop("disabled",!0),$("#submit_button_boleto").prop("disabled",!0)}})}))},error:function(e){$("#retorno_erro").removeClass("hidden"),$("#retorno_texto").html("O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente <br> Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos"),$("#submit_button").prop("disabled",!0),$("#submit_button_boleto").prop("disabled",!0)},complete:function(e){}})}else e.loading=!1,e.message("Campos Obrigatórios","Preencha todos os campos obrigatórios","error")}));case 2:case"end":return t.stop()}}),t)})))()},pagarBoleto:function(){var e=this;return i(r().mark((function t(){var a;return r().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return e.loading=!0,a=e.baseUrl+"/pagseguro/regionais/boleto",t.next=4,PagSeguroDirectPayment.onSenderHashReady((function(t){var o=t.senderHash;if(console.log(t),"error"==t.status)return e.loading=!1,e.message("Erro","O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente. Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos","error"),!1;e.$validator.validateAll().then((function(t){if(t){e.message("Aguarde...","Estamos processando seu pagamento","info");var r=e.form;r.hashBoleto=o,setTimeout((function(){$.ajax({method:"POST",url:a,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},data:$.param(r),dataType:"json",success:function(t){"error"==t.message?(e.message("Erro","Erro ao processar o pagamento, O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente. Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos.","error"),e.loading=!1):(e.message("Sucesso","Seu pagamento foi processado com sucesso","success"),e.loading=!1,window.open(t.response.paymentLink,"_blank"))},error:function(t){if(422==t.response.status&&"The given data was invalid."==t.response.data.message)return e.loading=!1,e.message("Erro","Erro ao processar o pagamento, O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente. Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos","error");500==t.response.status&&(e.loading=!1,e.message("Erro","Erro ao processar o pagamento, atualize sua página e tente novamente.","error")),403==t.response.status&&"This action is unauthorized."==t.response.data.message&&(e.loading=!1,e.message("Erro","Ação não autorizada.","error"))}})}),1e3)}else e.loading=!1,e.message("Erro","Erro ao processar o pagamento, O Pagseguro pode estar com lentidão ou instabilidade, clique no botão VOLTAR e tente novamente. Caso ja tenha feito esse processo mais de duas vezes, tente novamente em alguns minutos","error")}))}));case 4:case"end":return t.stop()}}),t)})))()},getProdutos:function(){var e=this;return i(r().mark((function t(){var a;return r().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return a=e.baseUrl+"/get/produtos-regionais",t.next=3,$.ajax({method:"GET",url:a,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},dataType:"json",success:function(t){e.produtos=t},error:function(e){console.log(e)}});case 3:case"end":return t.stop()}}),t)})))()}},created:function(){this.getProdutos()}};var l=a(3379),c=a.n(l),u=a(4989),m={insert:"head",singleton:!1};c()(u.Z,m);u.Z.locals;const p=(0,a(1900).Z)(d,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("b-modal",{attrs:{id:"pagar",size:"xl"},scopedSlots:e._u([{key:"modal-header",fn:function(t){var o=t.close;return[a("div",{staticClass:"text-center"},[a("div",{attrs:{align:"center"}},[a("p",{staticStyle:{"font-size":"18px !important","text-align":"center !important"}},[e._v("\n\t\t\t\t\tEscolha uma forma de Pagamento\n\t\t\t\t")])])]),e._v(" "),a("b-button",{attrs:{size:"sm",variant:"outline-danger"},on:{click:function(e){return o()}}},[e._v("x")])]}},{key:"modal-footer",fn:function(t){var o=t.cancel;return[a("div",{staticClass:"hidden",attrs:{id:"redirecionar_botao"}},[a("b-button",{attrs:{size:"xl",variant:"outline-success",disabled:e.loading},on:{click:function(t){return e.redirecionar()}}},[e._v("\n\t\t\tÁrea de Pagamentos\n\t\t\t")])],1),e._v(" "),a("b-button",{attrs:{size:"md",variant:"outline-danger",disabled:e.loading},on:{click:function(e){return o()}}},[e._v("\n\t\t\tCancelar\n\t\t")]),e._v(" "),a("b-button",{attrs:{id:"submit_button",disabled:e.loading,size:"md",variant:"outline-success"},on:{click:function(t){return e.pagarCredito()}}},[e._v("Pagar\n\t\t")])]}}])},[e._v(" "),[a("div",[a("b-card",{attrs:{"no-body":""}},[a("b-tabs",{attrs:{card:""}},[a("b-tab",{attrs:{title:"Cartão de Crédito",active:""}},[a("b-card-text",[a("div",{staticClass:"container"},[a("div",{staticClass:"section-head style-3 text-center z mb-3"},[a("h2",{staticClass:"title"},[e._v("Checkout "),a("img",{attrs:{src:e.baseUrl+"/images/pagseguro.png"}})]),e._v(" "),a("p",[e._v("Preencha os dados para finalizar o pagamento")]),e._v(" "),a("p",[e._v("Inscrição Regional "+e._s(this.regiao))])])]),e._v(" "),a("div",{staticClass:"container hidden",attrs:{id:"retorno_ok"}},[a("div",{staticClass:"section-head style-3 text-center z mb-3 alert alert-success",attrs:{role:"alert"}},[a("h2",{staticClass:"title",attrs:{id:"retorno_titulo_ok"}}),e._v(" "),a("p",{attrs:{id:"retorno_texto_ok"}})])]),e._v(" "),a("div",{staticClass:"container hidden",attrs:{id:"retorno_erro"}},[a("div",{staticClass:"section-head style-3 text-center z mb-3\talert alert-danger",attrs:{role:"alert"}},[a("h2",{staticClass:"title",attrs:{id:"retorno_titulo"}}),e._v(" "),a("p",{attrs:{id:"retorno_texto"}}),e._v(" "),a("div",[a("b-button",{attrs:{size:"xl",variant:"outline-danger"},on:{click:function(t){return e.recarregar()}}},[e._v("\n\t\t\t\t\t\t\t\tVoltar\n\t\t\t\t\t\t\t")])],1)])]),e._v(" "),a("div",{staticClass:"container"},[a("b-row",[a("b-col",{attrs:{cols:"12",sm:"6",lg:"6"}},[a("b-form-group",{attrs:{label:"Número do Cartão","label-class":"font-weight-bold"}},[a("b-form-input",{directives:[{name:"validate",rawName:"v-validate",value:{required:!0},expression:"{ required: true }"},{name:"mask",rawName:"v-mask",value:"####-####-####-####",expression:"'####-####-####-####'"}],class:["form-control form-control-sm",{"is-invalid":e.errors.has("numCartao")}],attrs:{name:"numCartao",size:"sm",type:"text",disabled:e.loading,"aria-describedby":"input-1-live-feedback","data-vv-as":"Número do Cartão"},on:{change:function(t){return e.validarBanderia()}},model:{value:e.form.numCartao,callback:function(t){e.$set(e.form,"numCartao",t)},expression:"form.numCartao"}}),e._v(" "),a("span",{directives:[{name:"show",rawName:"v-show",value:e.errors.has("numCartao"),expression:"errors.has(`numCartao`)"}],staticClass:"invalid-feedback"},[e._v("\n\t\t\t\t\t\t\t\t"+e._s(e.errors.first("numCartao"))+"\n\t\t\t\t\t\t\t\t")]),e._v(" "),a("div",{staticClass:"container hidden"},[a("div",{staticClass:"row"},[a("span",{staticClass:"col-6 input-group-text bandeira-cartao creditCard hidden",staticStyle:{"background-color":"#ffffff"},attrs:{id:"cartao-bandeira"}}),e._v(" "),a("span",{staticClass:"col-6 input-group-text  cartao-nome creditCard form-login-help  hidden",staticStyle:{"background-color":"#ffffff"},attrs:{type:"text",id:"cartao-nome"}})])])],1)],1),e._v(" "),a("b-col",{attrs:{cols:"12",sm:"6",lg:"6"}},[a("b-form-group",{attrs:{label:"Validade","label-class":"font-weight-bold"}},[a("b-form-input",{directives:[{name:"validate",rawName:"v-validate",value:{required:!0},expression:"{ required: true }"},{name:"mask",rawName:"v-mask",value:"##/##",expression:"'##/##'"}],class:["form-control form-control-sm",{"is-invalid":e.errors.has("validade")}],attrs:{name:"validade",size:"sm",type:"text",disabled:e.loading,"aria-describedby":"input-1-live-feedback","data-vv-as":"Validade"},model:{value:e.form.validade,callback:function(t){e.$set(e.form,"validade",t)},expression:"form.validade"}}),e._v(" "),a("span",{staticClass:"invalid-feedback",staticStyle:{"font-size":"12px !important"}},[e._v("\n\t\t\t\t\t\t\t\tEx: Formato da validade é 20/22\n\t\t\t\t\t\t\t\t")]),e._v(" "),a("span",{directives:[{name:"show",rawName:"v-show",value:e.errors.has("validade"),expression:"errors.has(`validade`)"}],staticClass:"invalid-feedback"},[e._v("\n\t\t\t\t\t\t\t\t"+e._s(e.errors.first("validade"))+"\n\t\t\t\t\t\t\t\t")])],1)],1),e._v(" "),a("b-col",{attrs:{cols:"12",sm:"6",lg:"6"}},[a("b-form-group",{attrs:{label:"Código de Segurança","label-class":"font-weight-bold"}},[a("b-form-input",{directives:[{name:"validate",rawName:"v-validate",value:{required:!0},expression:"{ required: true }"},{name:"mask",rawName:"v-mask",value:"####",expression:"'####'"}],class:["form-control form-control-sm",{"is-invalid":e.errors.has("cvv")}],attrs:{name:"cvv",size:"sm",type:"text",disabled:e.loading,"aria-describedby":"input-1-live-feedback","data-vv-as":"Código de Segurança"},model:{value:e.form.cvv,callback:function(t){e.$set(e.form,"cvv",t)},expression:"form.cvv"}}),e._v(" "),a("span",{directives:[{name:"show",rawName:"v-show",value:e.errors.has("cvv"),expression:"errors.has(`cvv`)"}],staticClass:"invalid-feedback"},[e._v("\n\t\t\t\t\t\t\t\t"+e._s(e.errors.first("cvv"))+"\n\t\t\t\t\t\t\t\t")])],1)],1),e._v(" "),a("b-col",{attrs:{cols:"12",sm:"6",lg:"6"}},[a("b-form-group",{attrs:{label:"Quantidade de Parcelas","label-class":"font-weight-bold"}},[a("b-form-select",{directives:[{name:"validate",rawName:"v-validate",value:{required:!0},expression:"{ required: true }"}],staticClass:"form-control form-control-sm",class:["form-control form-control-sm",{"is-invalid":e.errors.has("qntParcelas")}],attrs:{disabled:!0,name:"qntParcelas",id:"qntParcelas",size:"sm","data-vv-as":"Quantidade de Parcelas"},model:{value:e.form.qntParcelas,callback:function(t){e.$set(e.form,"qntParcelas",t)},expression:"form.qntParcelas"}}),e._v(" "),a("span",{directives:[{name:"show",rawName:"v-show",value:e.errors.has("qntParcelas"),expression:"errors.has(`qntParcelas`)"}],staticClass:"invalid-feedback"},[e._v("\n\t\t\t\t\t\t\t\t\t"+e._s(e.errors.first("qntParcelas"))+"\n\t\t\t\t\t\t\t\t")])],1)],1)],1),e._v(" "),a("div",{staticClass:"meio-pag-credito",staticStyle:{"padding-top":"10px","padding-bottom":"20px"},attrs:{id:"meio-pag-credito",name:"meio-pag-credito",align:"center"}}),e._v(" "),a("div",{staticClass:"hidden"},[a("form",{attrs:{method:"post","accept-charset":"utf-8",name:"formPagamentoCartaoCredito",id:"formPagamentoCartaoCredito",action:""}},[a("input",{attrs:{type:"hidden",name:"recupHashCartao",id:"recupHashCartao",value:""}}),e._v(" "),a("input",{attrs:{type:"hidden",name:"numCartao",id:"numCartao"},domProps:{value:e.form.numCartao}}),e._v(" "),a("input",{attrs:{type:"hidden",name:"cvv",id:"cvv"},domProps:{value:e.form.cvv}}),e._v(" "),a("input",{attrs:{type:"hidden",name:"validade",id:"validade"},domProps:{value:e.form.validade}}),e._v(" "),a("input",{attrs:{type:"hidden",name:"metodo",id:"metodo"},domProps:{value:e.form.metodo}}),e._v(" "),a("input",{attrs:{type:"hidden",name:"anuidade2022",id:"anuidade2022"},domProps:{value:1}}),e._v(" "),a("input",{attrs:{type:"hidden",name:"id",id:"id"},domProps:{value:e.form.id}}),e._v(" "),a("input",{attrs:{type:"hidden",name:"produto",id:"produto"},domProps:{value:e.form&&e.form.produto?e.form.produto.id:null}})])])],1)])],1),e._v(" "),a("b-tab",{attrs:{title:"Boleto"}},[a("b-card-text",[a("form",{staticClass:"form-horizontal",attrs:{action:"",method:"post","accept-charset":"utf-8",name:"formPagamentoBoleto",id:"formPagamentoBoleto"}},[a("fieldset",[a("div",{staticClass:"meio-pag-boleto",staticStyle:{"padding-bottom":"20px"},attrs:{align:"center"}})])])]),e._v(" "),a("div",{staticClass:"text-center"},[a("b-button",{attrs:{disabled:e.loading,size:"md",id:"submit_button_boleto",variant:"btn btn-success"},on:{click:function(t){return e.pagarBoleto()}}},[e._v("Gerar Boleto\n\t\t\t")])],1)],1)],1)],1)],1),e._v(" "),a("notifications",{attrs:{group:"submit",position:"center",width:"500px"}})]],2)}),[],!1,null,"24477ee2",null).exports}}]);