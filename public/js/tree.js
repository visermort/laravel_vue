window.onload = function () {

// define the item component
    Vue.component('tree-item', {
        template: '#item-template',
        props: {
            model: Object

        },
        data: function () {
            return {
                open: false,
                promised: true,
                childData: {}
  
            }
        },
        computed: {
        },
        methods: {
            isFolder: function () {
                return (this.childData &&
                    this.childData.length > 0) || this.promised;
            },

            toggle: function () {
                console.log('toggle',this.model.goods_id);
                if (this.promised == true && this.model.goods_id) {
                    this.getChilds(this.model.goods_id);
                }
                if (this.isFolder()) {
                    this.open = !this.open
                }
                this.promised = false;
            },
            //запрос на получение дочерних
            getChilds: function(id) {
                console.log(id);
                this.$http.get('/orders/'+id).then(function(response){
                    console.log(response.data);
                    this.childData = response.data;
                }).catch(function (error) {
                    console.log(error);
                });
            }
        }
    });


// boot up the demo
    var tree = new Vue({
        el: '#tree',
        data: {
            treeData: []
        },
        methods: {
            getChilds: function($url){

                this.$http.get($url).then(function(response){
                    console.log(response.data);
                    this.treeData = response.data;
                }).catch(function (error) {
                    console.log(error);
                });
            }
        },
        mounted: function() {

            this.getChilds('/api/goods');
        }

    })





};
