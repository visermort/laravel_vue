<template>
    <transition name="modal">
        <div class="modal-mask" v-on:click="$emit('close')" >
            <div class="modal-wrapper"  >
                <div class="modal-container modal-form" v-bind:class="modalParams.status" v-on:click.stop >

                    <div class="modal-form__header">
                        <div class="modal-form__header_text" >{{ modalParams.title }}</div>
                    </div>

                    <div class="modal-form__body">
                        <div class="modal-form__body_message" >{{ modalParams.message  }}</div>
                    </div>

                    <div class="modal-form__footer">
                        <button v-show="modalParams.url" class="btn btn-default modal-form__button" v-on:click="runAction">OK</button>
                        <button class="modal-form__button btn btn-default" v-on:click="$emit('close')">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </transition>

</template>

<script>

    import bus from './bus';

    export default {
        //name: 'modal_component',
        props: {
            params: {}
        },
        methods: {
            runAction: function() {
                this.modalClose();
                //console.log(this.modalParams.url, this.modalParams.id);
                //запрос
                this.$http.post(this.modalParams.url, {
                    id: this.modalParams.id
                }).then(function(response){
                    console.log(response);
                    if (response.data ) {
                        console.log(response.data);
                        this.postMessage(response.data.status ? '' : 'modalerror', response.data.message);
                    } else {
                        console.log(response);
                        this.postMessage('modalerror', response.statusText);
                    }

                }).catch(function (error) {
                    console.log(error);
                    this.postMessage('modalerror', 'Ошибка обращения к серверу');
                });
            },
            postMessage: function(status, message) {
                //вызываем событие - cообщение о выполненной операции
                bus.$emit('confirm_action', {
                    'title': 'Result of action!',
                    'message': message,
                    'status': status,
                    'url': '',
                    'id': 0
                });
            },
            modalClose: function() {
                bus.$emit('modal_close');
            }
        },
        computed: {
            modalParams: function() {
                return this.params;
            }
        },
        data: function() {
            return {

            }
        }
    }



</script>


<style>
    /*modal*/
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-container {
        width: 300px;
        margin: 0 auto;
        /*padding: 10px 30px;*/
        background-color: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
        border: 3px solid #42b983;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
    }
    .modal-container.modalerror {
        border-color: #c6445c;
    }
    .modal-container.modalwarning {
        border-color: #ceb33b;
    }
    .modal-form__header {
        color: #fff;
        text-align: center;
        padding: 2px;
        margin: 3px 3px;
    }
    .modal-container .modal-form__header {
        background-color: #42b983;
    }
    .modal-container.modalerror .modal-form__header {
        background-color: #c6445c;
    }
    .modal-container.modalwarning .modal-form__header {
        background-color: #ceb33b;
    }


    .modal-form__header_text {
        padding: 5px;
        font-size: 18px;
    }

    .modal-form__body {
        margin: 20px 0;
        text-align: center;
    }
    .modal-form__footer {
        margin: 15px;
        text-align: center;
    }

    .modal-form__button {
        width: 80px;
        line-height: 1.8em;
        margin-right: 20px;
    }

    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }

</style>