window.onload = function () {


    var goodsApp = new Vue({
        el: '#orders',
        data: {
            list: {},
            inputs: {
                name: '',
                price: ''
            },
            errors: {}
        },

        methods: {

        },
        mounted: function() {
            console.log('orders')

        }
    });





};
