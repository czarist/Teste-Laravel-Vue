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

require('./bootstrap');

import Vue from 'vue'
window.moment = require('moment/moment');
Vue.component('v-select', vSelect)
Vue.use(Notifications)
Vue.use(Tooltip);
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VeeValidate)
Vue.use(VueMask)

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

Validator.localize('pt_BR', pt_BR)

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
                    valid: retorna
                }

            },
            error: (retorna) => {
            }
        });
    }
})

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
            }
        }
    }
});


import SexoGrid from './components/admin/sexo/SexoGrid.vue'
import InstituicaoGrid from './components/admin/instituicao/InstituicaoGrid.vue'
import TitulacaoGrid from './components/admin/titulacao/TitulacaoGrid.vue'
import AssociadoGrid from './components/admin/associado/AssociadoGrid.vue'
import UsuarioGrid from './components/admin/usuario/UsuarioGrid.vue'
import FormPerfil from './components/perfil/FormPerfil.vue'
import FormCadastro from './components/cadastro/FormCadastro.vue'
// import PagarModal from './components/cadastro/PagarModal.vue'
import FilieseCadastro from './components/cadastro/FilieseCadastro.vue'
import AssociadoArea from './components/associado/AssociadoArea.vue'
import PagamentoGrid from './components/pagamento/PagamentoGrid.vue'
import AnuidadeCadastro from './components/associado/AnuidadeCadastro.vue'
import FormAvaliador from './components/ficha_avaliador/FormAvaliador.vue'
import FormIndicacao from './components/indicacao/FormIndicacao.vue'
import RegionalSulForm from './components/regionais/sul/RegionalSulForm.vue'


const app = new Vue({
    el: '#app',
    components: {
        'form-perfil': FormPerfil,
        'sexo-grid': SexoGrid,
        'instituicao-grid': InstituicaoGrid,
        'titulacao-grid': TitulacaoGrid,
        'associado-grid': AssociadoGrid,
        'usuario-grid': UsuarioGrid,
        'form-cadastro': FormCadastro,
        // 'pagar-modal': PagarModal,
        'filiese-cadastro': FilieseCadastro,
        'associado-area': AssociadoArea,
        // 'pagar-modal-anuidade': PagarModalAnuidade,
        'pagamento-grid': PagamentoGrid,
        'anuidade-cadastro': AnuidadeCadastro,
        'form-avaliador': FormAvaliador,
        'form-indicacao': FormIndicacao,
        'regional-sulform': RegionalSulForm,

    }
});

window.axios.defaults.headers = {
    "Access-Control-Allow-Origin": "*",
    'Access-Control-Allow-Methods':'GET,PUT,POST,DELETE,PATCH,OPTIONS',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

};
