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

import SexoGrid from './components/admin/sexo/SexoGrid.vue'
import InstituicaoGrid from './components/admin/instituicao/InstituicaoGrid.vue'
import TitulacaoGrid from './components/admin/titulacao/TitulacaoGrid.vue'
import AssociadoGrid from './components/admin/associado/AssociadoGrid.vue'
import UsuarioGrid from './components/admin/usuario/UsuarioGrid.vue'
import FormPerfil from './components/perfil/FormPerfil.vue'
import FormCadastro from './components/cadastro/FormCadastro.vue'
import PagamentosGrid from './components/admin/pagamentos/PagamentosGrid.vue'
import IndicacaoExpocomGrid from "./components/admin/indicacao/IndicacaoExpocomGrid.vue"

// import PagarModal from './components/cadastro/PagarModal.vue'
import FilieseCadastro from './components/cadastro/FilieseCadastro.vue'
import AssociadoArea from './components/associado/AssociadoArea.vue'
import PagamentoGrid from './components/pagamento/PagamentoGrid.vue'
import AnuidadeCadastro from './components/associado/AnuidadeCadastro.vue'
import FormAvaliador from './components/ficha_avaliador/FormAvaliador.vue'
import FormAvaliadorNacional from './components/ficha_avaliador/FormAvaliadorNacional.vue'
import FormIndicacao from './components/indicacao/FormIndicacao.vue'

//FORM INSCRICOES 
import RegionalSulForm from './components/regionais/sul/RegionalSulForm.vue'
import RegionalNorteForm from './components/regionais/norte/RegionalNorteForm.vue'
import RegionalNordesteForm from './components/regionais/nordeste/RegionalNordesteForm.vue'
import RegionalSuldesteForm from './components/regionais/suldeste/RegionalSuldesteForm.vue'
import RegionalCentrooesteForm from './components/regionais/centrooeste/RegionalCentrooesteForm.vue'
import InscricaoNacionalForm from './components/nacional/InscricaoNacionalForm.vue'

//SUBMISSAO NACIONAL
import SubmissaoNacionalForm from './components/nacional/SubmissaoNacionalForm.vue'

//SUBMICOES SUL
import SubmissaoSul from './components/regionais/sul/SubmissaoSul.vue'
import SubmissaoExpocomSul from './components/regionais/sul/SubmissaoExpocomSul.vue'

//SUBMICOES SUDESTE
import SubmissaoSudeste from './components/regionais/suldeste/SubmissaoSudeste.vue'
import SubmissaoExpocomSudeste from './components/regionais/suldeste/SubmissaoExpocomSudeste.vue'

//SUBMICOES NORTE
import SubmissaoNorte from './components/regionais/norte/SubmissaoNorte.vue'
import SubmissaoExpocomNorte from './components/regionais/norte/SubmissaoExpocomNorte.vue'

//SUBMICOES NORDESTE
import SubmissaoNordeste from './components/regionais/nordeste/SubmissaoNordeste.vue'
import SubmissaoExpocomNordeste from './components/regionais/nordeste/SubmissaoExpocomNordeste.vue'

//SUBMICOES CENTRO-OESTE
import SubmissaoCentrooeste from './components/regionais/centrooeste/SubmissaoCentrooeste.vue'
import SubmissaoExpocomCentrooeste from './components/regionais/centrooeste/SubmissaoExpocomCentrooeste.vue'

//CADASTRO COORDENADOR 
import CoordenadorGrid from './components/admin/coordenador/CoordenadorGrid.vue'

//AVALIACAO DE TRABALHOS
import AvaliacaoGrid from './components/regionais/avaliacao/AvaliacaoGrid.vue'

//AREA DO AVALIADOR
import AvaliadorGrid from './components/regionais/avaliador/AvaliadorGrid.vue'

//GRID AVALIADO (AUTOR DA SUBMISSAO)
import AvaliadoGrid from './components/regionais/avaliado/AvaliadoGrid.vue'

                    //AVALIACAO EXPOCOM//

//AVALIACAO DE TRABALHOS EXPOCOM
import AvaliacaoExpocomGrid from './components/regionais/avaliacaoExpocom/AvaliacaoExpocomGrid.vue'

//AREA DO AVALIADOR EXPOCOM
import AvaliadorExpocomGrid from './components/regionais/avaliadorExpocom/AvaliadorExpocomGrid.vue'

//GRID AVALIADO (AUTOR DA SUBMISSAO) EXPOCOM
import AvaliadoExpocomGrid from './components/regionais/avaliadoExpocom/AvaliadoExpocomGrid.vue'

//DASHBOARD
import DashboardPage from './components/admin/dashboard/DashboardPage.vue'

//GRID TRABALHOS ACEITOS EXPOCOM
import ListaTrabalhosExpocomGrid from './components/lista_trabalhos_aceitos_expocom/ListaTrabalhosExpocomGrid.vue'

//GRID TRABALHOS ACEITOS
import ListaTrabalhosGrid from './components/lista_trabalhos_aceitos/ListaTrabalhosGrid.vue'

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
        'form-avaliador-nacional': FormAvaliadorNacional,
        'form-indicacao': FormIndicacao,

        //ADMIN PAGAMENTOS
        'pagamentos-grid': PagamentosGrid,

        //ADMIN INDICACAO
        'indicacao_expocom-grid': IndicacaoExpocomGrid,

        //INSCRICOES
        'regional-sulform': RegionalSulForm,
        'regional-norteform': RegionalNorteForm,
        'regional-nordesteform': RegionalNordesteForm,
        'regional-suldesteform': RegionalSuldesteForm,
        'regional-centrooeste': RegionalCentrooesteForm,
        'inscricao-nacional': InscricaoNacionalForm,

        //SUBMISSAO NACIONAL 2022
        'submissao-nacional': SubmissaoNacionalForm,

        //SUBMISSOES SUL 2022
        'submissao-sul':SubmissaoSul,
        'submissao-expocom-sul':SubmissaoExpocomSul,

        //SUBMISSOES SUDESTE 2022
        'submissao-sudeste':SubmissaoSudeste,
        'submissao-expocom-sudeste':SubmissaoExpocomSudeste,
        
        //SUBMISSOES NORTE 2022
        'submissao-norte':SubmissaoNorte,
        'submissao-expocom-norte':SubmissaoExpocomNorte,

        //SUBMISSOES NORDESTE 2022 
        'submissao-nordeste':SubmissaoNordeste,
        'submissao-expocom-nordeste':SubmissaoExpocomNordeste,

        //SUBMISSOES CENTRO-OESTE 2022 
        'submissao-centrooeste':SubmissaoCentrooeste,
        'submissao-expocom-centrooeste':SubmissaoExpocomCentrooeste,

        //CADASTRO COORDENADOR 
        'coordenador-grid': CoordenadorGrid,

        //AVALIACAO DE TRABALHOS
        'avaliacao-grid':AvaliacaoGrid,
        'avaliador-grid':AvaliadorGrid,

        //AVALIACAO DE TRABALHOS EXPOCOM
        'avaliacao-expocom-grid':AvaliacaoExpocomGrid,
        'avaliador-expocom-grid':AvaliadorExpocomGrid,        

        //GRID AVALIADO (AUTOR DA SUBMISSAO)
        'submissao-grid':AvaliadoGrid,

        //GRID AVALIADO EXPOCOM (AUTOR DA SUBMISSAO)
        'submissao-expocom-grid':AvaliadoExpocomGrid,

        //DASHBOARD
        'dashboard-page': DashboardPage,

        //GRID TRABALHOS ACEITOS EXPOCOM
        'lista-trabalhos-expocom-grid': ListaTrabalhosExpocomGrid,

        //GRID TRABALHOS ACEITOS
        'lista-trabalhos-grid': ListaTrabalhosGrid

    }
});

window.axios.defaults.headers = {
    "Access-Control-Allow-Origin": "*",
    'Access-Control-Allow-Methods':'GET,PUT,POST,DELETE,PATCH,OPTIONS',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

};
