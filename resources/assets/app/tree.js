
import bus from './components/bus';

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
        },
        writeData: function (data) {
            this.objectsData = data.data;
            this.objectsTemplate = data.template;
        }

    },
    mounted: function() {
        //после загрузки грузим данные
        this.getChilds('/api/goods2');
        //по событию - клик на элемент - копирование данных в инстанс
        var func = this.writeData;
        bus.$on('treeItemClick', function(data) {
            func(data);
        });
    }

});