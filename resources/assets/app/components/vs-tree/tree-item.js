import treebus from './treebus';

// define the item component
Vue.component('tree-item', {
    template: require('./tree-item.html'),
    //style: require('./tree.css'),
    props: {
        model: Object
    },
    data: function () {
        return {
            status: 'promised', //promised, open, close
            childData: {},
            loading: false,
            itemContent: {
                objectTemplate: '',//по значению будет включаться нужный блок (шаблон)
                objectData: {}//данные объкта
            }
        }
    },
    computed: {
        nodeClass: function (){
            if (this.loading) {
                return 'loading';
            } else if ((this.status === 'promised' || this.status === 'closed'  ) && this.model.isFolder) {
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
            if (this.status === 'promised') {
                this.getChilds();
            }
            if (this.status === 'open') {
                this.status = 'closed';
                //     console.log(this.status);
            } else if (this.status === 'closed') {
                this.status = 'open';
                //     console.log(this.status);
            }
        },
        //запрос на получение дочерних
        getChilds: function() {
            console.log(this.model.childsLink);
            let that = this;
            if (this.model.childsLink !== '') {
                that.loading = true;
                that.$http.get(this.model.childsLink).then(function (response) {
                    that.loading = false;
                    console.log(response.data);
                    that.childData = response.data;
                    that.model.isFolder = this.childData.length > 0;
                    that.status = this.childData.length > 0 ? 'open' : 'document';
                }).catch(function (error) {
                    that.loading = false;
                    console.log(error);
                });
            } else {
                that.status = 'document';
            }
        },
        //клик на объект
        getObject: function(url){
            //console.log(url);
            //если objectTemplate пустой, то запрос на получение данных
            let that = this;
            if (that.itemContent.objectTemplate === '') {
                that.loading = true;
                this.$http.get(url).then(function (response) {
                    that.loading = false;
                    console.log(response.data);
                    that.itemContent.objectData = response.data.object;
                    that.itemContent.objectTemplate = response.data.template;
                    that.copyData();

                }).catch(function (error) {
                    that.loading = false;
                    console.log(error);
                });
            } else {
                that.copyData();
            }

        },
        copyData: function () {
            //перенос данных из компонента в компонент контента
            console.log('copyData', this.itemContent);
            treebus.$emit('treeItemClick', {
                data: this.itemContent,
            });
        }
        
    }
});
