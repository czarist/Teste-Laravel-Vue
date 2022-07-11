import VueApexCharts from 'vue-apexcharts'

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import moment from 'moment'
import { debounce } from "debounce"
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
import 'bootstrap-vue/dist/bootstrap-vue-icons.min.css'
import Notifications from 'vue-notification'
import Tooltip from 'vue-directive-tooltip'
import 'vue-directive-tooltip/dist/vueDirectiveTooltip.css'
import VeeValidate, { Validator, } from 'vee-validate'
import pt_BR from 'vee-validate/dist/locale/pt_BR'
import VueMask from 'v-mask'
import Editor from '@tinymce/tinymce-vue'

require('./bootstrap');
require('datatables.net-bs4')

import Vue from 'vue'
window.moment = require('moment/moment');
Vue.use(VueApexCharts);
Vue.component('v-select', vSelect)
Vue.use(Notifications)
Vue.use(Tooltip);
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VeeValidate)
Vue.use(VueMask)
Vue.component('editor', Editor)

Vue.filter('momentFullDate', function (date) {
    return date ? moment(date).format('DD/MM/YYYY HH:mm') : null
})

Vue.filter('momentDate', function (date) {
    return date ? moment(date).format('DD/MM/YYYY') : null
});


Vue.filter('formatPrice', function (value) {
    let val = (value/1).toFixed(2).replace('.', ',')
    return 'R$'+' ' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
})


Validator.extend("fullName", {
    validate: (fullName) => {
        var regName = /^[a-zA-ZáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ]+( [a-zA-ZáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ]+)+$/;
        var name = fullName;
        if(!regName.test(name)){
            return false;
        }else{
            return true;
        }
    
    }
})

Validator.extend("numeroSocioCheck", {
    validate: (numero_socio, id) => {
        var numero_socioo = {'numero_socio': numero_socio}
        return  $.ajax({
            method: "POST",
            url: `${process.env.MIX_BASE_URL}/admin/associado/check`,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: numero_socioo,
            dataType: 'json',
            success: (retorna) => {
                return {
                    valid: retorna
                }

            },
            error: (retorna) => {
            }
        });

    }
})

Validator.extend("emailCheck", {
    validate: (email) => {
        var emaill = {'email': email}
        return  $.ajax({
            method: "POST",
            url: `${process.env.MIX_BASE_URL}/perfil/emailcheck`,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: emaill,
            dataType: 'json',
            success: (retorna) => {
                return {
                    valid: retorna
                }

            },
            error: (retorna) => {
            }
        });
    }
})

Validator.extend("emailCadastro", {
    validate: (email) => {
        var emaill = {'email': email}
        return  $.ajax({
            method: "POST",
            url: `${process.env.MIX_BASE_URL}/cadastro/emailcheck`,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: emaill,
            dataType: 'json',
            success: (retorna) => {
                return {
                    valid: retorna
                }

            },
            error: (retorna) => {
            }
        });
    }
})

Validator.extend("cpfCheck", {
    validate: (cpf) => {
        var cpff = {'cpf': cpf}
        return  $.ajax({
            method: "POST",
            url: `${process.env.MIX_BASE_URL}/cadastro/cpfcheck`,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: cpff,
            dataType: 'json',
            success: (retorna) => {
                return {
                    valid: retorna
                }

            },
            error: (retorna) => {
            }
        });
    }
})

Validator.extend("cpfCheckIndicacao", {
    validate: (cpf) => {
        var cpff = {'cpf': cpf}
        return  $.ajax({
            method: "POST",
            url: `${process.env.MIX_BASE_URL}/indicacao/cpfcheckindicacao`,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: cpff,
            dataType: 'json',
            success: (retorna) => {
                return {
                    valid: retorna
                }
            },
            error: (retorna) => {
            }
        });
    }
})

Validator.extend("passaporteCheck", {
    validate: (passaporte) => {
        var passaportee = {'passaporte': passaporte}

        return  $.ajax({
            method: "POST",
            url: `${process.env.MIX_BASE_URL}/cadastro/passaportecheck`,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: passaportee,
            dataType: 'json',
            success: (retorna) => {
                return {
                    valid: retocopyna
                }

            },
            error: (retorna) => {
            }
        });
    }
})

Validator.extend("verificaCPF", {
    validate: (valor) => {

        var valor = valor.replace(/[^\d]+/g,'');    

        var primeiro=valor.substr(1,1);
        var falso=true;
        var size=valor.length;
        if (size!=11){
            return false;
        }
        size--;
        for (var i=2; i<size-1; ++i){
            var proximo=(valor.substr(i,1));
            if (primeiro!=proximo) {
                falso=false
            }
        }
        if (falso){
            return false;
        }
        if(modulo(valor.substring(0,valor.length - 2)) + "" + modulo(valor.substring(0,valor.length - 1)) != valor.substring(valor.length - 2,valor.length)) {
            return false;
        }
        return true
    }
})

function modulo(str) {

    var soma=0;
    var ind=2;
    for(var pos=str.length-1;pos>-1;pos=pos-1) {
        soma = soma + (parseInt(str.charAt(pos)) * ind);
        ind++;
        if(str.length>11) {
            if(ind>9) ind=2;
        }
 }
    var resto = soma - (Math.floor(soma / 11) * 11);
    if(resto < 2) {
     return 0
    }
    else {
        return 11 - resto
    }
}


Validator.localize({
    pt_BR: {
        messages: {
            date_format: 'Formato invalido',
        },
        custom: {
            email: {
                emailCheck: 'E-mail já cadastrado',
                emailCadastro: 'E-mail já cadastrado'
            },
            numero_socio: {
                numeroSocioCheck: 'Número sócio já em uso'
            },      
            password: {
                passCheck: 'Senha incorreta'
            },
            cpf: {
                cpfCheckIndicacao: 'CPF já indicado',
                cpfCheck: 'CPF já cadastrado',
            },
            passaporte: {
                passaporteCheck: 'Passaporte já cadastrado'
            },
            name: {
                fullName : "Nome completo digitado não é válido "
            }
        }
    }
});

Validator.localize('pt_BR', pt_BR)

import UsuarioGrid from './components/admin/usuario/UsuarioGrid.vue'
import FormPerfil from './components/perfil/FormPerfil.vue'
import FormCadastro from './components/admin/usuario/FormUsuario.vue'



const app = new Vue({
    el: '#app',
    components: {
        'form-perfil': FormPerfil,
        'usuario-grid': UsuarioGrid,
        'form-cadastro': FormCadastro
    }
});

window.axios.defaults.headers = {
    "Access-Control-Allow-Origin": "*",
    'Access-Control-Allow-Methods':'GET,PUT,POST,DELETE,PATCH,OPTIONS',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
};
