

var tree = new Vue({
    el: '#goods',
    data: {
        treeData: [],
        objectsData: {},
        objectsTemplate: ''
    },
    methods: {
        getChilds: function(url){

            this.$http.get(url).then(function(response){
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
