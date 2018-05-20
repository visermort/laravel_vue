
import bus from './bus';

//компонент содержимого - однофайловый компонент
Vue.component('content-element', require('./content.vue'));

//экземпляр - содержимое
var contentElement = new Vue({
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