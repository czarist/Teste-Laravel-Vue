<template>
    <b-modal id="modalEscolhaChat" size="lg" no-close-on-backdrop>
        <template #modal-header="{ close }">
            <h5>ESCOLHA QUAL AVALIADOR DESEJA CONVERSAR </h5>
            <b-button size="sm" variant="outline-danger" @click="close()">X</b-button>
        </template>
        <template>

            <div class="modal-body scroll pb-0" ref="scroll">
                <div>
                    <button
                        v-if="
                            selectedAvaliacao && selectedAvaliacao.avaliacao && selectedAvaliacao.avaliacao.status_coordenador && selectedAvaliacao.avaliacao.status_coordenador != 'Aceito' &&
                            selectedAvaliacao && selectedAvaliacao.avaliacao && selectedAvaliacao.avaliacao.status_coordenador && selectedAvaliacao.avaliacao.status_coordenador != 'Recusado' && 
                            selectedAvaliacao && selectedAvaliacao.avaliacao.avaliador_1 != null ||

                            selectedAvaliacao && selectedAvaliacao.avaliacao && selectedAvaliacao.avaliacao.status_coordenador && selectedAvaliacao.avaliacao.status_coordenador == 'Em Espera' && selectedAvaliacao.avaliacao.avaliador_1 != null ||
                            selectedAvaliacao && selectedAvaliacao.avaliacao && selectedAvaliacao.avaliacao.status_coordenador && selectedAvaliacao.avaliacao.status_coordenador == 'Em Análise' && selectedAvaliacao.avaliacao.avaliador_1 != null ||
                            selectedAvaliacao && selectedAvaliacao.avaliacao && selectedAvaliacao.avaliacao.status_coordenador && selectedAvaliacao.avaliacao.status_coordenador == 'Em avaliação' && selectedAvaliacao.avaliacao.avaliador_1 != null ||

                            selectedAvaliacao && selectedAvaliacao.avaliacao && !selectedAvaliacao.avaliacao.status_coordenador &&
                            selectedAvaliacao && selectedAvaliacao.avaliacao && selectedAvaliacao.avaliacao.avaliador_1 != null
                        "
                        v-tooltip.bottom="{
                            content: 'MENSAGEM P/ AVALIADOR',
                            delay: 0,
                            class: 'tooltip-custom tooltip-arrow'
                        }"
                        @click="resetModalChat(),getChat(selectedAvaliacao.avaliacao, 1)"
                        type="button"
                        class="btn btn-lg btn-block btn-primary p-1 m-3"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
                            <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                            <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9.06 9.06 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.437 10.437 0 0 1-.524 2.318l-.003.011a10.722 10.722 0 0 1-.244.637c-.079.186.074.394.273.362a21.673 21.673 0 0 0 .693-.125zm.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6c0 3.193-3.004 6-7 6a8.06 8.06 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a10.97 10.97 0 0 0 .398-2z"/>
                        </svg>
                        <span >AVALIADOR 1</span>
                    </button>

                    <button
                        v-if="
                            selectedAvaliacao && selectedAvaliacao.avaliacao && selectedAvaliacao.avaliacao.status_coordenador && selectedAvaliacao.avaliacao.status_coordenador != 'Aceito' &&
                            selectedAvaliacao && selectedAvaliacao.avaliacao && selectedAvaliacao.avaliacao.status_coordenador && selectedAvaliacao.avaliacao.status_coordenador != 'Recusado' && 
                            selectedAvaliacao && selectedAvaliacao.avaliacao.avaliador_2 != null ||

                            selectedAvaliacao && selectedAvaliacao.avaliacao && selectedAvaliacao.avaliacao.status_coordenador && selectedAvaliacao.avaliacao.status_coordenador == 'Em Espera' && selectedAvaliacao.avaliacao.avaliador_2 != null ||
                            selectedAvaliacao && selectedAvaliacao.avaliacao && selectedAvaliacao.avaliacao.status_coordenador && selectedAvaliacao.avaliacao.status_coordenador == 'Em Análise' && selectedAvaliacao.avaliacao.avaliador_2 != null ||
                            selectedAvaliacao && selectedAvaliacao.avaliacao && selectedAvaliacao.avaliacao.status_coordenador && selectedAvaliacao.avaliacao.status_coordenador == 'Em avaliação' && selectedAvaliacao.avaliacao.avaliador_2 != null ||

                            selectedAvaliacao && selectedAvaliacao.avaliacao && !selectedAvaliacao.avaliacao.status_coordenador &&
                            selectedAvaliacao && selectedAvaliacao.avaliacao && selectedAvaliacao.avaliacao.avaliador_2 != null
                        "
                        v-tooltip.bottom="{
                            content: 'MENSAGEM P/ AVALIADOR',
                            delay: 0,
                            class: 'tooltip-custom tooltip-arrow'
                        }"
                        @click="resetModalChat(),getChat(selectedAvaliacao.avaliacao, 2)"
                        type="button"
                        class="btn btn-lg btn-block btn-primary p-1 m-3"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
                            <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                            <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9.06 9.06 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.437 10.437 0 0 1-.524 2.318l-.003.011a10.722 10.722 0 0 1-.244.637c-.079.186.074.394.273.362a21.673 21.673 0 0 0 .693-.125zm.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6c0 3.193-3.004 6-7 6a8.06 8.06 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a10.97 10.97 0 0 0 .398-2z"/>
                        </svg>
                        <span>AVALIADOR 2</span>
                    </button>

                    <button
                        v-if="
                            selectedAvaliacao && selectedAvaliacao.avaliacao && selectedAvaliacao.avaliacao.status_coordenador && selectedAvaliacao.avaliacao.status_coordenador != 'Aceito' &&
                            selectedAvaliacao && selectedAvaliacao.avaliacao && selectedAvaliacao.avaliacao.status_coordenador && selectedAvaliacao.avaliacao.status_coordenador != 'Recusado' && 
                            selectedAvaliacao && selectedAvaliacao.avaliacao.avaliador_3 != null ||

                            selectedAvaliacao && selectedAvaliacao.avaliacao && selectedAvaliacao.avaliacao.status_coordenador && selectedAvaliacao.avaliacao.status_coordenador == 'Em Espera' && selectedAvaliacao.avaliacao.avaliador_3 != null ||
                            selectedAvaliacao && selectedAvaliacao.avaliacao && selectedAvaliacao.avaliacao.status_coordenador && selectedAvaliacao.avaliacao.status_coordenador == 'Em Análise' && selectedAvaliacao.avaliacao.avaliador_3 != null ||
                            selectedAvaliacao && selectedAvaliacao.avaliacao && selectedAvaliacao.avaliacao.status_coordenador && selectedAvaliacao.avaliacao.status_coordenador == 'Em avaliação' && selectedAvaliacao.avaliacao.avaliador_3 != null ||

                            selectedAvaliacao && selectedAvaliacao && selectedAvaliacao.avaliacao && !selectedAvaliacao.avaliacao.status_coordenador &&
                            selectedAvaliacao.avaliacao && selectedAvaliacao.avaliacao.avaliador_3 != null
                        "
                        v-tooltip.bottom="{
                            content: 'MENSAGEM P/ AVALIADOR',
                            delay: 0,
                            class: 'tooltip-custom tooltip-arrow'
                        }"
                        @click="resetModalChat(),getChat(selectedAvaliacao.avaliacao, 3)"
                        type="button"
                        class="btn btn-lg btn-block btn-primary p-1 m-3"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
                            <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                            <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9.06 9.06 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.437 10.437 0 0 1-.524 2.318l-.003.011a10.722 10.722 0 0 1-.244.637c-.079.186.074.394.273.362a21.673 21.673 0 0 0 .693-.125zm.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6c0 3.193-3.004 6-7 6a8.06 8.06 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a10.97 10.97 0 0 0 .398-2z"/>
                        </svg>
                        <span>AVALIADOR 3</span>
                    </button>
                </div>

                <chat-avaliador-modal :selectedChat="selectedChat" :user="user" :mensagens="mensagens" :scroll.sync="scroll"></chat-avaliador-modal>
                <chat-avaliador2-modal :selectedChat="selectedChat" :user="user" :mensagens="mensagens" :scroll.sync="scroll"></chat-avaliador2-modal>
                <chat-avaliador3-modal :selectedChat="selectedChat" :user="user" :mensagens="mensagens" :scroll.sync="scroll"></chat-avaliador3-modal>
            </div>

        </template>
            <template #modal-footer="{ cancel }">
                <b-button size="md" variant="outline-danger" @click="cancel()" :disabled="loading">
                    Cancelar
                </b-button>
        </template>
    </b-modal>
</template>

<script>

import ChatAvaliadorModal from './ChatAvaliadorModal.vue'
import ChatAvaliador2Modal from './ChatAvaliador2Modal.vue'
import ChatAvaliador3Modal from './ChatAvaliador3Modal.vue'

export default {
    props: ['chooseChat','user', 'coordenador'],
    components: {
        ChatAvaliadorModal:() => import('./ChatAvaliadorModal.vue'),
        ChatAvaliador2Modal:() => import('./ChatAvaliador2Modal.vue'),
        ChatAvaliador3Modal:() => import('./ChatAvaliador3Modal.vue')
    },
    data(){
        return {
            loading: false,
            baseUrl: process.env.MIX_BASE_URL,
            dataScroll: false,
            scroll: false,
            moment: moment,
            mensagens: [],
            selectedAvaliacao: null,
            selectedChat: {
                id : null,
                avaliacao_id : null,
                coordenador_id : null,
                coordenador : null,
                send_avaliador : null,
                mensagem : null,
                avaliado_id : null,
                avaliador_id : null
            },
        }
    },
    watch: {
        chooseChat: {
            handler:function(newVal) {
                this.selectedAvaliacao = newVal 
            },
            deep:true
        }

    },
    methods: {
        cancel(){
            $('modalEscolhaChat').modal('hide');
        },
        resetModalChat() {
            this.selectedChat.id = null,
            this.selectedChat.avaliacao_id = null,
            this.selectedChat.coordenador_id = null,
            this.selectedChat.coordenador = null,
            this.selectedChat.send_avaliador = null,
            this.selectedChat.mensagem = null,
            this.selectedChat.avaliado_id = null,
            this.selectedChat.avaliador_id = null
        },
        async getChat(avaliacao, indexChat) {
            if(avaliacao && avaliacao.id){
                await axios.get(`${this.baseUrl}/coordenador/nacional/get/chat/avaliador/${avaliacao.id}`)
                .then(res =>{
                    if(res.data.length > 0){
                        this.mensagens = res.data
                        this.selectedChat.avaliacao_id = (res.data && res.data[0]) ? res.data[0].avaliacao_id : avaliacao && avaliacao.id ? avaliacao.id : null
                        this.selectedChat.coordenador_id = this.selectedAvaliacao && this.selectedAvaliacao.coordenador && this.selectedAvaliacao.coordenador.id ? this.selectedAvaliacao.coordenador.id : null
                        this.selectedChat.coordenador = this.selectedAvaliacao && this.selectedAvaliacao.coordenador ? this.selectedAvaliacao.coordenador : null
                        this.selectedChat.send_avaliador = indexChat ? indexChat : null
                        this.selectedChat.avaliacao = avaliacao ? avaliacao : null
                        this.selectedChat.mensagem = null
                        this.$validator.reset('mensagens')

                    } else{
                        this.mensagens = []
                        this.selectedChat.id = avaliacao && avaliacao.id ? avaliacao.id : null
                        this.selectedChat.avaliacao_id = (res.data && res.data[0]) ? res.data[0].avaliacao_id : avaliacao && avaliacao.id ? avaliacao.id : null
                        this.selectedChat.coordenador_id = this.selectedAvaliacao && this.selectedAvaliacao.coordenador && this.selectedAvaliacao.coordenador.id ? this.selectedAvaliacao.coordenador.id : null
                        this.selectedChat.coordenador = this.selectedAvaliacao && this.selectedAvaliacao.coordenador ? this.selectedAvaliacao.coordenador : null
                        this.selectedChat.send_avaliador = indexChat ? indexChat : null
                        this.selectedChat.avaliacao = avaliacao ? avaliacao : null
                        this.$validator.reset('mensagens')
                    }

                    if(indexChat == 1){
                        $('#modalChatAvaliador').modal({backdrop: 'static', keyboard: false, show: true})
                        this.$bvModal.show('modalChatAvaliador')
                    }

                    if(indexChat == 2){
                        $('#modalChatAvaliador2').modal({backdrop: 'static', keyboard: false, show: true})
                        this.$bvModal.show('modalChatAvaliador2')
                    }

                    if(indexChat == 3){
                        $('#modalChatAvaliador3').modal({backdrop: 'static', keyboard: false, show: true})
                        this.$bvModal.show('modalChatAvaliador3')
                    }
                })
            }
        }
    },
}
</script>

<style scoped>
    ::v-deep .modal-backdrop {
        opacity: 0.5 !important;
    }
</style>