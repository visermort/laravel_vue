
import vsbus from './vsbus';


Vue.component('modal-component', require('./modal.vue'));

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');

Vue.component('vs-grid', {
    template: require('./vs-grid.html'),
    style: require('./grid.css'),
    props: {
        config: {
            gridColumns: [
                {'key': 'id', 'value': 'Id'},
                {'key': 'title', 'value': 'Title',},
                {'key': 'description', 'value': 'Description', 'sort': false}
            ],
            requestUrl: '',
            requestContent: {
                url: '',
                key: ''
            },
            actions: [ //кнопки действий для каждой строки
            ],
            actionsCommon: [ //кнопки действий для всей таблицы, для выбранных строк
            ],
            actionsCommonDisable: '', //действия недоступны для строк - условие из поля данных
            perPages: [
                {title: '15', count: 15},
                {title: '25', count: 25},
                {title: '50', count: 50},
                {title: '100', count: 100}
            ],
            perPage: 25,
            contentElement: {}
        }
    },
    data: function () {
        let sortOrders = {};
        //console.log(this.config);
        this.config.gridColumns.forEach(function (key) {
            if (key.sort == null || key.sort) {
                sortOrders[key.key] = 1
            }
        });
        return {
            gridData: {},
            sortKey: '',
            sortOrders: sortOrders,
            dataPage: 1,
            searchQuery: '',
            loading: [],
            checkAll: false,//выбраны все checkbox
            checkedId: [], //массив выбранных checkbox
            idList: [],     //список id - для наполнения предыдущего массива
            localPerPage: 0,
            contentdata: {
                key: null,
                data: {}
            },

        }
    },
    computed: {
        paginateButtons: function () {
            let result = [],
                pageOffset = 2;
            if (!this.gridData || !this.gridData.last_page || this.gridData.last_page == 0) {
                return result;
            } else {
                let from = this.dataPage - pageOffset > 0 ? this.dataPage - pageOffset : 1,
                    to = this.dataPage + pageOffset <= this.gridData.last_page ?
                        this.dataPage + pageOffset : this.gridData.last_page;
                if (this.dataPage > pageOffset + 1) {
                    result.push({title: '<<', page: 1});
                }
                if (this.dataPage > 1) {
                    result.push({title: '<', page: this.dataPage - 1});
                }
                for (let i = from; i <= to; i++) {
                    result.push({title: i, page: i});
                }
                if (this.dataPage < this.gridData.last_page) {
                    result.push({title: '>', page: this.dataPage + 1});
                }
                if (this.dataPage < this.gridData.last_page - pageOffset) {
                    result.push({title: '>>', page: this.gridData.last_page});
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
        runAction: function (action, method, id, message) {
            if (action) {
                //console.log(action, method, id, message);
                if (method === 'get') {
                    //get - просто ссылка + ид
                    window.location = action + id;
                } else {
                    //пост
                    //вызываем событие на подтвержение операции
                    vsbus.$emit('confirm_action', {
                        'title': 'Please, confirm action!',
                        'message': message,
                        'status': true,
                        'url': action,
                        'id': id
                    });
                }
            }
        },
        runCommonAction: function (action, message) {
            //console.log(action, message, this.checkedId);
            if (action && this.checkedId.length > 0) {
                //вызываем событие на подтвержение операции
                vsbus.$emit('confirm_action', {
                    'title': 'Please, confirm action!',
                    'message': message,
                    'status': '',
                    'url': action,
                    'id': this.checkedId
                });

            } else if (this.checkedId.length === 0) {
                //сообщение, что не выбраны строки
                vsbus.$emit('confirm_action', {
                    'title': 'Warning!',
                    'message': 'Please, select some rows!',
                    'status': 'modalwarning',
                    'url': '',
                    'id': 0
                });
            }
        },
        getRequest: function () {
            let data = {};
            if (this.dataPage > 0) {
                data.page = this.dataPage;
            }
            if (this.sortKey) {
                data.sort = this.sortKey;
                data.dir = this.sortOrders[this.sortKey];
            }
            if (this.searchQuery) {
                data.search = this.searchQuery;
            }
            if (this.localPerPage > 0) {
                data.per_page = this.localPerPage;
                console.log('perpage ' + data.per_page);
            }
            let that = this;

            this.doRequest(
                this.config.requestUrl,//url
                {params: data, loading: 0},//data
                function (response) {
                    that.gridData = response.data.payments;
                    //для селектов очицаем массив и делаем список всех доступных ид
                    that.checkAll = false;
                    that.checkedId = []; //массив выбранных checkbox
                    let idList2 = [];
                    let columns2 = that.config.gridColumns;
                    let actions_common_disable2 = that.config.actions_common_disable;
                    that.gridData.data.forEach(function (item) {
                        if (actions_common_disable2 == null || !item[actions_common_disable2]) {
                            idList2.push(item[columns2[0].key]);
                        }
                    });
                    that.idList = idList2;
                },
                function (error) {
                    that.checkAll = false;
                    that.checkedId = [];
                    that.idList = [];
                });
        },
        makeSeach: function () {
            this.dataPage = 1;
            this.getRequest();
        },
        headerCheckClick: function () {
            this.checkedId = [];
            if (this.checkAll) {
                this.checkedId = this.idList;
            }
        },
        setLocalPerPage: function () {
            this.localPerPage = this.config.perPage;
        },
        handleDrop(item, data) {
            this.moveColumn(data.moved, item);
        },

        moveColumn: function (from, to) {
            let element = this.config.gridColumns[from];
            this.config.gridColumns.splice(from, 1);
            this.config.gridColumns.splice(to, 0, element);
        },

        doRequest: function (url, data, callback, fail) {
            let that = this;
            that.loading = [];

            if (data && data.loading !== null) {
                that.loading[data.loading] = true;
            }
            //запрос
            this.$http.get(url, data).then(function (response) {
                that.loading = [];
                console.log(response);
                callback(response);
            }).catch(function (error) {
                that.loading = [];
                console.log(error);
                if (fail) {
                    fail(error);
                }
            });
        },
        gridDataToggle: function(key) {
            if (this.contentdata.key !== key) {
                this.gridDataClick(key);
            } else {
                this.contentdata.key = null;
                this.contentdata.data = null;
            }

        },
        gridDataClick: function (key) {
            console.log(key);
            //this.contentdata.key = key;
            let that = this;
            this.doRequest(
                this.config.requestContent.url + '/' + key,
                {loading: key}, //для прелоадера
                function (response) {
                    //if (that.contentElement && response.body) {
                    if (response.body) {
                        //contentElement.props.params = response.body;
                        //console.log(contentElement.props.params);
                        that.contentdata.key = key;
                        that.contentdata.data = response.body;
                    }
                },
                function () {
                    that.contentdata.key = null;
                });
        }
    },
    mounted: function () {
        //внутри функци  this не виден, поэтому переменная
        let that = this;
        //ловим событие
        vsbus.$on('loadconfig', function () {
            console.log('После старта делаем запрос');
            that.setLocalPerPage();//переписать perPage из конфиг
            //в этом месте нужно делать запрос, но поскольку он запускается при изменении localPerPage, запускать специально не нужно
        });
    },
    watch: {
        localPerPage: function () {
            //console.log(this.localPerPage);
            this.dataPage = 1;
            this.getRequest();
        }
    }
});
