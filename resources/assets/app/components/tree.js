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
            loading: false,
            objectTemplate: '',//по значению будет включаться нужный блок (шаблон)
            objectData: {}//данные объкта
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
        },
        //клик на объект
        getObject: function(url){
            console.log(url);
            //если objectTemplate пустой, то запрос на получение данных
            if (this.objectTemplate == '') {
                this.loading = true;
                this.$http.get(url).then(function (response) {
                    this.loading = false;
                    console.log(response.data);
                    this.objectData = response.data.object;
                    this.objectTemplate = response.data.template;
                    tree.objectsData = this.objectData;
                    tree.objectsTemplate = this.objectTemplate;
                    console.log(tree.objectsData, tree.objectsTemplate)

                }).catch(function (error) {
                    this.loading = false;
                    console.log(error);
                });
            } else {
                tree.objectsData = this.objectData ? this.objectData : {};
                tree.objectsTemplate = this.objectTemplate;
                console.log(tree.objectsData, tree.objectsTemplate)
            }

        }
    }
});
