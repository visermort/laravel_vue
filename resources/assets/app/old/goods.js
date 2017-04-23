window.onload = function () {


    Vue.component('good-item', {
        //компонент для вывода списков
        props: ['item'],
        template: '<li class="good_item">{{ item.goods_id }} . {{ item.goods_name }}  {{ item.goods_price}}</li>'
    });

    var goodsApp = new Vue({
        el: '#goods',
        data: {
            list: {},
            inputs: {
                name: '',
                price: ''
            },
            errors: {}
        },

        methods: {
            getItems: function(){
                this.$http.get('/api/goods').then(function(response){
                    console.log(response.data);
                    goodsApp.list = response.data;
                }).catch(function (error) {
                    console.log(error);
                });
            },
            goodAdd: function(){
                this.$http.post('/api/goods/add', this.inputs, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('#token').getAttribute('content')
                    }
                }).then(function(response){
                    console.log('success', response);
                    goodsApp.errors = {};
                    goodsApp.getItems();
                }).catch(function (data) {
                    console.log('error', data.data);
                    goodsApp.errors = data.data;
                });
            }
        },
        mounted: function() {

            //setTimeout(function(){
                this.getItems()
            //}, 50);

        }
    });





};
