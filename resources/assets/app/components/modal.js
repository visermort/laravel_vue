
import bus from './bus';

//компонент модального окна - однофайловый компонент
Vue.component('modal-component', require('./modal.vue'));

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
            //console.log(data);
            func(data);
        });
        //закрытие окна
        bus.$on('modal_close', function() {
            funcClose();
        });

    }
});
