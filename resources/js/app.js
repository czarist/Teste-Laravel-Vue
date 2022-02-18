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
window.moment = require('moment/moment');
Vue.component('v-select', vSelect)
Vue.use(Notifications)
Vue.use(Tooltip);
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VeeValidate);

Validator.localize('pt_BR', pt_BR)

Validator.localize({
    pt_BR: {
        messages: {
            date_format: 'Formato invalido',
        },
        
        custom: {
            email: {
                emailCheck: 'E-mail já em uso'
            },      
            password: {
                passCheck: 'Senha incorreta'
            }
        }
    }
});

import SexoGrid from './components/config/sexo/SexoGrid.vue'

const app = new Vue({
    el: '#app',
    components: {
        'sexo-grid': SexoGrid
    }
});
