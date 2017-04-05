window.onload = function () {

// define the item component
    Vue.component('tree-item', {
        template: '#item-template',
        props: {
            model: Object
        },
        data: function () {
            return {
                status: 'promised', //promised, open, close
                childData: {},
                loading: false
            }
        },
        computed: {
            nodeClass: function (){
                if (this.loading) {
                    return 'loading';
                } else if ((this.status == 'promised' || this.status == 'closed'  ) && this.model.isFolder) {
                    return 'closed';
                } else if (this.model.isFolder) {
                    return 'open';
                } else {
                    return 'document';
                }
            }
        },
        methods: {
            toggle: function () {
               // console.log('toggle' ,this.model.childsLink);
                if (this.status == 'promised') {
                    this.getChilds();
                }
                if (this.status == 'open') {
                    this.status = 'closed';
               //     console.log(this.status);
                } else if (this.status == 'closed') {
                    this.status = 'open';
               //     console.log(this.status);
                }
            },
            //запрос на получение дочерних
            getChilds: function() {
                console.log(this.model.childsLink);
                if (this.model.childsLink != '') {
                    this.loading = true;
                    this.$http.get(this.model.childsLink).then(function (response) {
                        this.loading = false;
                        console.log(response.data);
                        this.childData = response.data;
                        this.model.isFolder = this.childData.length > 0;
                        this.status = this.childData.length > 0 ? 'open' : 'document';
                    }).catch(function (error) {
                        this.loading = false;
                        console.log(error);
                    });
                } else {
                    this.status = 'document';
                }
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

            this.getChilds('/api/goods2');
        }

    });





};
