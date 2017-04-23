
import bus from './bus';

// register modal component
Vue.component('modal-component', {
    template: '#modal-template',
    // template: '<transition name="modal">'+
    //         '<div class="modal-mask" v-on:click="$emit("close")" >'+
    //             '<div class="modal-wrapper"  >'+
    //                 '<div class="modal-container modal-form" v-bind:class="modalParams.status" v-on:click.stop >'+
    //                     '<div class="modal-form__header">'+
    //                         '<div class="modal-form__header_text" >@{{ modalParams.title }}</div>'+
    //                     '</div>'+
    //
    //                     '<div class="modal-form__body">'+
    //                         '<div class="modal-form__body_message" >@{{ modalParams.message  }}</div>'+
    //                     '</div>'+
    //
    //                     '<div class="modal-form__footer">'+
    //                         '<button v-show="modalParams.url" class="btn btn-default modal-form__button" v-on:click="runAction">OK</button>'+
    //                         '<button class="modal-form__button btn btn-default" v-on:click="$emit("close")">Close</button>'+
    //                     '</div>'+
    //                 '</div>'+
    //             '</div>'+
    //         '</div>'+
    //     '</transition>',
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

});

//экземпляр - модальное окно
var modal = new Vue({
    el: '#modal',
    data: {
        params: {
            title: '',
            message: '',
            url: '',
            id: 0,
            status: ''
        },
        showModal: false
    },
    methods: {
        showModalWindow: function(data) {
            this.params.title = data.title;
            this.params.message = data.message;
            this.params.status = data.status;
            this.params.id = data.id;
            this.params.url = data.url;
            this.showModal = true;
        },
        modalClose: function() {
            this.showModal = false;
        }
    },
    mounted: function() {
        //реакция на событие - вызов модального окна
        var func = this.showModalWindow;
        var funcClose = this.modalClose;
        bus.$on('confirm_action', function(data){
            //вызываем метод
            func(data);
        });
        //закрытие окна
        bus.$on('modal_close', function() {
            funcClose();
        });

    }
});
