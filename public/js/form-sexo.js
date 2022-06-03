"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[798],{5428:(s,t,e)=>{e.d(t,{Z:()=>i});var o=e(1519),a=e.n(o)()((function(s){return s[1]}));a.push([s.id,"[data-v-738b49ed] .modal-backdrop{opacity:.5!important}",""]);const i=a},8319:(s,t,e)=>{e.r(t),e.d(t,{default:()=>d});const o={props:["selected","id"],mixins:[e(2063).Z],data:function(){return{loading:!1,post:{id:null,tipo_sexo:null,_method:"post"}}},watch:{selected:function(){this.selected?(this.post.id=this.selected.id,this.post.tipo_sexo=this.selected.tipo_sexo,this.post._method="put"):this.clear()}},computed:{url:function(){return this.post&&this.post.id?"/".concat(this.post.id):""}},methods:{save:function(){var s=this;this.$validator.validate().then((function(t){t?(s.message("Aguarde...","Estamos salvando suas informações","info",-1),s.loading=!0,axios.post("".concat("https://www.homolog.intercom.org.br","/admin/sexo").concat(s.url),s.post).then((function(t){s.clear(),201==t.status?(s.loading=!1,s.$emit("store",t.data.response)):(s.loading=!1,s.$emit("update",t.data.response)),s.message("Sucesso",201==t.status?"Registro cadastrado.":"Registro atualizado.","success")})).catch((function(t){if(422==t.response.status&&"The given data was invalid."==t.response.data.message)return s.loading=!1,s.message("Campos Obrigatórios","Preencha todos os campos obrigatórios","error");400==t.response.status&&(s.loading=!1,s.message("Erro","Por favor tente novamente.","error")),403==t.response.status&&"This action is unauthorized."==t.response.data.message&&(s.loading=!1,s.message("Erro","Ação não autorizada.","error"))}))):s.message("Campos Obrigatórios","Preencha todos os campos obrigatórios","error")}))},clear:function(){this.post.id=null,this.post.tipo_sexo=null,this.post._method="post",this.$validator.reset("tipo_sexo")}}};var a=e(3379),i=e.n(a),r=e(5428),n={insert:"head",singleton:!1};i()(r.Z,n);r.Z.locals;const d=(0,e(1900).Z)(o,(function(){var s=this,t=s.$createElement,e=s._self._c||t;return e("b-modal",{attrs:{id:"sexoModal","no-close-on-backdrop":""},scopedSlots:s._u([{key:"modal-header",fn:function(t){var o=t.close;return[s.post.id?e("h5",[s._v("Editar Gênero")]):e("h5",[s._v("Cadastrar Gênero")]),s._v(" "),e("b-button",{attrs:{size:"sm",variant:"outline-danger"},on:{click:function(s){return o()}}},[s._v("x")])]}},{key:"modal-footer",fn:function(t){var o=t.cancel;return[e("b-button",{attrs:{size:"md",variant:"outline-danger",disabled:s.loading},on:{click:function(s){return o()}}},[s._v("\n                Cancelar\n            ")]),s._v(" "),e("b-button",{attrs:{size:"md",variant:"outline-success",disabled:s.loading},on:{click:function(t){return s.save()}}},[s._v("\n                "+s._s(s.post.id?"Atualizar":"Cadastrar")+"\n            ")])]}}])},[s._v(" "),[e("b-form-group",{attrs:{label:"Tipo de sexo","label-class":"font-weight-bold"}},[e("b-form-input",{directives:[{name:"validate",rawName:"v-validate",value:{required:!0},expression:"{ required: true }"}],class:["form-control form-control-sm",{"is-invalid":s.errors.has("tipo_sexo")}],attrs:{name:"tipo_sexo",size:"sm",type:"text","aria-describedby":"input-1-live-feedback","data-vv-as":"tipo de sexo",disabled:s.loading},model:{value:s.post.tipo_sexo,callback:function(t){s.$set(s.post,"tipo_sexo",t)},expression:"post.tipo_sexo"}}),s._v(" "),e("span",{directives:[{name:"show",rawName:"v-show",value:s.errors.has("tipo_sexo"),expression:"errors.has(`tipo_sexo`)"}],staticClass:"invalid-feedback"},[s._v("\n                "+s._s(s.errors.first("tipo_sexo"))+"\n            ")])],1)]],2)}),[],!1,null,"738b49ed",null).exports}}]);