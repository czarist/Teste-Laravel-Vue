import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import moment from 'moment'
import { debounce } from "debounce"
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
import 'bootstrap-vue/dist/bootstrap-vue-icons.min.css'
import Notifications from 'vue-notification'
import Tooltip from 'vue-directive-tooltip';
import 'vue-directive-tooltip/dist/vueDirectiveTooltip.css';
import VeeValidate, { Validator, } from 'vee-validate'
import pt_BR from 'vee-validate/dist/locale/pt_BR'

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
Vue.use(VeeValidate);

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
                emailCheck: 'E-mail já em uso'
            },     
            numero_socio: {
                numeroSocioCheck: 'Número sócio já em uso'
            },      
            password: {
                passCheck: 'Senha incorreta'
            }
        }
    }
});

import SexoGrid from './components/admin/sexo/SexoGrid.vue'
import InstituicaoGrid from './components/admin/instituicao/InstituicaoGrid.vue'
import TitulacaoGrid from './components/admin/titulacao/TitulacaoGrid.vue'
import AssociadoGrid from './components/admin/associado/AssociadoGrid.vue'
import UsuarioGrid from './components/admin/usuario/UsuarioGrid.vue'
import ProfilePage from './components/perfil/ProfilePage.vue'

const app = new Vue({
    el: '#app',
    components: {
        'profile-page': ProfilePage,
        'sexo-grid': SexoGrid,
        'instituicao-grid': InstituicaoGrid,
        'titulacao-grid': TitulacaoGrid,
        'associado-grid': AssociadoGrid,
        'usuario-grid': UsuarioGrid,

    }
});
