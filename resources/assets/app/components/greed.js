

Vue.component('grid-paginate-ajax', {
    template: '#grid-template-ajax',
    props: {
        config: {}
    },
    data: function () {
        var sortOrders = {};
        //console.log(this.config);
        this.config.gridColumns.forEach(function (key) {
            if (key.sort == null || key.sort) {
                sortOrders[key.key] = 1
            }
        });
        return {
            gridData: Array,
            paginateData: {},
            sortKey: '',
            sortOrders: sortOrders,
            dataPage: 1,
            searchQuery: '',
            loading: false,
            checkAll: false,//выбраны все checkbox
            checkedId: [], //массив выбранных checkbox
            idList: [],     //список id - для наполнения предыдущего массива
            localPerPage: 0
        }
    },
    computed: {
        paginateButtons: function(){
            var result = [],
                pageOffset = 2;
            if (!this.paginateData || !this.paginateData.last_page || this.paginateData.last_page == 0) {
                return result;
            } else {
                var from = this.dataPage-pageOffset > 0 ? this.dataPage-pageOffset : 1,
                    to = this.dataPage+pageOffset <= this.paginateData.last_page ?
                    this.dataPage+pageOffset : this.paginateData.last_page;
                if (this.dataPage > pageOffset + 1) {
                    result.push({title: '<<', page: 1});
                }
                if (this.dataPage > 1) {
                    result.push({title: '<', page: this.dataPage-1});
                }
                for (var i = from; i <= to; i++){
                    result.push({title: i, page: i});
                }
                if (this.dataPage < this.paginateData.last_page) {
                    result.push({title: '>', page: this.dataPage+1});
                }
                if (this.dataPage < this.paginateData.last_page - pageOffset) {
                    result.push({title: '>>', page: this.paginateData.last_page});
                }
            }
            return result;
        }
    },
    filters: {
        capitalize: function (str) {
            return str.charAt(0).toUpperCase() + str.slice(1)
        }
    },
    methods: {
        sortBy: function (key) {
            this.sortKey = key;
            this.sortOrders[key] = this.sortOrders[key] * -1;
            this.getRequest();
        },
        setPage: function (page) {
            this.dataPage = page;
            this.getRequest();
        },
        runAction: function(action, method, id, message){
            if (action) {
                //console.log(action, method, id, message);
                if (method == 'get') {
                    //get - просто ссылка + ид
                    window.location = action + id;
                } else {
                    //пост
                    //вызываем событие на подтвержение операции
                    bus.$emit('confirm_action', {
                        'title': 'Please, confirm action!',
                        'message': message,
                        'status': true,
                        'url': action,
                        'id': id
                    });
                }
            }
        },
        runCommonAction: function(action, message){
            //console.log(action, message, this.checkedId);
            if (action && this.checkedId.length > 0) {
                //вызываем событие на подтвержение операции
                bus.$emit('confirm_action', {
                    'title': 'Please, confirm action!',
                    'message': message,
                    'status': '',
                    'url': action,
                    'id': this.checkedId
                });

            } else if (this.checkedId.length == 0){
                //сообщение, что не выбраны строки
                bus.$emit('confirm_action', {
                    'title': 'Warning!',
                    'message': 'Please, select some rows!',
                    'status': 'modalwarning',
                    'url': '',
                    'id': 0
                });
            }
        },
        getRequest: function() {
            var data = {};
            if (this.dataPage > 0) {
                data.page = this.dataPage;
            }
            if (this.sortKey) {
                data.sort = this.sortKey;
                data.dir =this.sortOrders[this.sortKey];
            }
            if (this.searchQuery) {
                data.search = this.searchQuery;
            }
            if (this. localPerPage > 0 ){
                data.per_page = this. localPerPage;
                console.log('perpage '+data.per_page);
            }

            this.loading = true;
            //запрос
            this.$http.get(this.config.requestUrl, {params: data}).then(function(response){
                this.loading = false;
                console.log(response);
                this.gridData = response.data.payments.data;
                //для селектов очицаем массив и делаем список всех доступных ид
                this.checkAll = false;
                this.checkedId = []; //массив выбранных checkbox
                var idList2 = [];
                var columns2 = this.config.gridColumns;
                var actions_common_disable2 = this.config.actions_common_disable;
                this.gridData.forEach(function(item){
                    if (actions_common_disable2 == null || !item[actions_common_disable2]) {
                        idList2.push(item[columns2[0].key]);
                    }
                });
                this.idList = idList2;

                this.paginateData = {
                    from: response.data.payments.from,
                    to: response.data.payments.to,
                    total: response.data.payments.total,
                    per_page: response.data.payments.per_page,
                    current_page: response.data.payments.current_page,
                    last_page: response.data.payments.last_page,
                    next_page_url: response.data.payments.next_page_url,
                    prev_page_url: response.data.payments.prev_page_url
                };
            }).catch(function (error) {
                this.loading = false;
                console.log(error);
                this.checkAll = false;
                this.checkedId = [];
                this.idList = [];
            });
        },
        makeSeach: function (){
            this.dataPage = 1;
            this.getRequest();
        },
        headerCheckClick: function () {
            this.checkedId = [];
            if (this.checkAll) {
                this.checkedId = this.idList;
            }
        },
        setLocalPerPage: function(){
            this.localPerPage = this.config.perPage;
        }
    },
    mounted: function(){
        //внутри функци  метод не виден, поэтому переменная
        var func = this.setLocalPerPage;
        //ловим событие
        bus.$on('loadconfig', function(){
            console.log('После старта делаем запрос');
            func();//переписать perPage из конфиг
            //в этом месте нужно делать запрос, но поскольку он запускается при изменении localPerPage, запускать специально не нужно
        });
    },
    watch: {
        localPerPage: function(){
            //console.log(this.localPerPage);
            this.dataPage = 1;
            this.getRequest();
        }
    }
});

