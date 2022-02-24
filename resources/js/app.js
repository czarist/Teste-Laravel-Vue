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
Vue.filter('momentDate', function (date) {
    return date ? moment(date).format('DD/MM/YYYY') : null
});
window.moment = require('moment/moment');
Vue.component('v-select', vSelect)
Vue.use(Notifications)
Vue.use(Tooltip);
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VeeValidate)
Vue.use(VueMask)

Validator.localize('pt_BR', pt_BR)

Validator.extend("numeroSocioCheck", {
    validate: (numero_socio, id) => {
        return axios.post(`${process.env.MIX_BASE_URL}/admin/associado/check`, {numero_socio, id}).then(res => {
            return {
                valid: res.data
            }
        })
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
                cpfCheck: 'CPF já cadastrado'
            },
            passaporte: {
                passaporteCheck: 'Passaporte já cadastrado'
            }
        }
    }
});

Validator.extend("emailCheck", {
    validate: (email, id) => {
        return axios.post(`${process.env.MIX_BASE_URL}/perfil/emailcheck`, {email, id}).then(res => {
            return {
                valid: res.data
            }
        })
    }
})

Validator.extend("emailCadastro", {
    validate: (email) => {
        return axios.post(`${process.env.MIX_BASE_URL}/cadastro/emailcheck`, {email}).then(res => {
            return {
                valid: res.data
            }
        })
    }
})

Validator.extend("cpfCheck", {
    validate: (cpf) => {
        return axios.post(`${process.env.MIX_BASE_URL}/cadastro/cpfcheck`, {cpf}).then(res => {
            return {
                valid: res.data
            }
        })
    }
})

Validator.extend("passaporteCheck", {
    validate: (passaporte) => {
        console.log(passaporte)
        return axios.post(`${process.env.MIX_BASE_URL}/cadastro/passaportecheck`, {passaporte}).then(res => {
            return {
                valid: res.data
            }
        })
    }
})



import SexoGrid from './components/admin/sexo/SexoGrid.vue'
import InstituicaoGrid from './components/admin/instituicao/InstituicaoGrid.vue'
import TitulacaoGrid from './components/admin/titulacao/TitulacaoGrid.vue'
import AssociadoGrid from './components/admin/associado/AssociadoGrid.vue'
import UsuarioGrid from './components/admin/usuario/UsuarioGrid.vue'
import ProfilePage from './components/perfil/ProfilePage.vue'
import FormCadastro from './components/cadastro/FormCadastro.vue'
import PagarModal from './components/cadastro/PagarModal.vue'

const app = new Vue({
    el: '#app',
    components: {
        'profile-page': ProfilePage,
        'sexo-grid': SexoGrid,
        'instituicao-grid': InstituicaoGrid,
        'titulacao-grid': TitulacaoGrid,
        'associado-grid': AssociadoGrid,
        'usuario-grid': UsuarioGrid,
        'form-cadastro': FormCadastro,
        'pagar-modal': PagarModal,

    }
});


