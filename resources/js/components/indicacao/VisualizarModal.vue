<template>
    <b-modal id="visualizar" size="xl">
        <template #modal-header="{ close }">
            <div class="text-center">
               <p style="font-size:18px !important; text-align:center !important;">Indicação Salva</p>
            </div>
            <b-button size="xl" variant="outline-danger" @click="close()">x</b-button>
        </template>
        <template>
            <div>
                <b-card header-tag="header" footer-tag="footer">
                    <template #header>
                        <h6 class="mb-0">INDICAÇÃO DA IES</h6>
                    </template>
                    <b-card-text>
                        Categoria: {{ selected ? selected.categoria : null }}<br/>
                        Modalidade: {{ selected ? selected.modalidade : null}}<br/>
                        Titulo: {{ selected ? selected.titulo_trabalho : null}}<br/> 
                        Trabalho produzido: {{ selected ? selected.trabalho_produzido : null}}<br/>
                    </b-card-text>
                    <template #footer>
                        <em>Autor: {{ selected ? selected.nome_autor : null}}</em>
                    </template>
                </b-card>
            </div>
             <notifications group="submit" position="center" width="500px" />
        </template>

        <template #modal-footer="{ cancel }">
            <b-button
                size="xl"
                variant="outline-success"
                @click="redirecionar()"
                :disabled="loading"
            >
                Home
            </b-button>

            <b-button
                size="md"
                variant="outline-danger"
                @click="cancel()"
                :disabled="loading"
            >
                Cancelar
            </b-button>

        </template>
    </b-modal>
</template>

<script>
    import MixinsGlobal from  '../mixins/global-mixins'
    import debounce from 'debounce'

    export default {
        props: ['selected', 'id'],
        mixins: [ MixinsGlobal],
        data() {
            return {            
                loading: false,
                url: process.env.MIX_BASE_URL,
            }
        },
        watch: {
        },
        computed:{
        },
        methods: {
            redirecionar(){
                window.location.href = '/';
            },
        },
        created() {
        },
    }

</script>


<style scoped>
    ::v-deep .modal-backdrop {
        opacity: 0.5 !important;
    }
    ::v-deep .vue-notification {
        font-size: 15px !important;
    }

</style>
