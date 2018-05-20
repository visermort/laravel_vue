//компонент содержимого - однофайловый компонент
Vue.component('content-element', require('./content.vue'));

//экземпляр - содержимое
let contentElement = new Vue({
    el: '#contentElement',
    data: {
        params: {

        }

    },
    methods: {


    },
    mounted: function() {
    }
});