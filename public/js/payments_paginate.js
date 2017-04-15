window.onload = function () {

    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');

// register the grid component
    Vue.component('grid-paginate-ajax', {
        template: '#grid-template-ajax',
        props: {
            columns: Array,
            actions: Array,
            actions_common: Array,
            actions_common_disable: '',
            request_url: ''
        },
        data: function () {
            var sortOrders = {};
            this.columns.forEach(function (key) {
                sortOrders[key.key] = 1
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
                idList: []     //список id - для наполнения предыдущего массива
            }
        },
        computed: {
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
                    console.log(action, method, id, message);
                    if (method == 'get') {
                        window.location = action + id;
                    } else {
                        modal.title = 'Please, confirm action!';
                        modal.message = message;
                        modal.status = true;
                        modal.url = action;
                        modal.id = id;
                        modal.showModal = true;
                    }
                }
            },
            runCommonAction: function(action, message){
                console.log(action, message, this.checkedId);
                if (action && this.checkedId.length > 0) {
                    modal.title = 'Please, confirm action!';
                    modal.message = message;
                    modal.status = true;
                    modal.url = action;
                    modal.id = this.checkedId;
                    modal.showModal = true;
                }
            },
            getRequest: function() {
                var data = {};
                    page: this.dataPage
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

                this.loading = true;
                this.$http.get(this.request_url, {params: data}).then(function(response){
                    this.loading = false;
                    console.log(response);
                    this.gridData = response.data.payments.data;
                    //для селектов очицаем массив и делаем список всех доступных ид
                    this.checkAll = false;
                    this.checkedId = []; //массив выбранных checkbox
                    var idList2 = [];
                    var columns2 = this.columns;
                    var actions_common_disable2 = this.actions_common_disable;
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
            }
        },
        mounted: function(){
            this.getRequest();
        }
    });

// экземпляр - грид
    var GridPaginate = new Vue({
        el: '#demoGrid',
        data: {
            searchQuery: '',
            extConfig: '',
            gridColumns: [
                {'key': 'payment_id', 'value': 'Id'},
                {'key': 'payment_order_id', 'value': 'Order Id'},
                {'key': 'payment_summ', 'value': 'Сумма'},
                {'key': 'payment_client_name', 'value': 'Клиент'},
                {'key': 'payment_client_phone', 'value': 'Телефон'},
                {'key': 'payment_status', 'value': 'Статус'},
                {'key': 'created_at', 'value': 'Дата'}
            ],
            url: '/payments-data-paginate',
            actions: [ //кнопки действий для каждой строки
                {
                    'value': '<i class="fa fa-pencil" aria-hidden="true"></i>',
                    'title': 'Edit payment',
                    'action': '/payments/edit/',
                    'method': 'get'
                   // 'disable': ''//кнопка актива если условие  не задаём
                },
                {
                    'value': '<i class="fa fa-trash" aria-hidden="true"></i>',
                    'title': 'Delete payment',
                    'action': '/payments/delete',
                    'method': 'post',
                    'message': 'Do you really want to delete payment?',
                    'disable' : 'disable_delete'//кнопка не активана условие из поля данных, сформировано в бек
                }
            ],
            actionsCommon: [ //кнопки действий для всей таблицы, для выбранных строк
                {
                    'value': '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    'title': 'Export selected payment',
                    'action': '/payments/export',
                    'message': 'Checked payment will be exported'
                },
                {
                    'value': '<i class="fa fa-trash" aria-hidden="true"></i>',
                    'title': 'Delete selected payment',
                    'action': '/payments/common-delete',
                    'message': 'Do you really want to delete selected payments?'
                }

            ],
            actionsCommonDisable: 'check_box_disable' //действия недоступны для строк - условие из поля данных

        },
        methods: {
            config: function(){
                //внешняя конфигурация - получается из бека и корректирует поля в instance
                //например columns, actions, actionCommon - позволяет загрузить одну страницу, но в зависимости 
                //от реквест корректировать грид
                this.extConfig = JSON.parse(document.querySelector('#grid-data-form-config').getAttribute('value'));
                for (item in this.extConfig){
                   console.log(item);
                    if (this[item]) {
                        this[item] = this.extConfig[item];
                    }
                }
            }
        },
        mounted: function(){
            this.config();//корректировка конфигурации
        }

    });


    // register modal component
    Vue.component('modal-component', {
        template: '#modal-template',
        props: {
            component_url: '',
            component_status: true
        },
        methods: {
            close: function() {
                this.showModal = false;
            },
            runAction: function() {
                modal.showModal = false;
                console.log(modal.url, modal.id);

                this.$http.post(modal.url, {
                    id: modal.id
                }).then(function(response){
                     console.log(response);
                    if (response.data ) {
                        console.log(response.data);
                        this.postMessage(response.data.status, response.data.message);
                    } else {
                        console.log(response);
                        this.postMessage(false, response.statusText);
                    }

                }).catch(function (error) {
                    console.log(error);
                    this.postMessage(false, 'Ошибка обращения к серверу');
                });
            },
            postMessage: function(status, message) {
                console.log(status, message);
                modal.url = '';
                modal.title = 'Result of action';
                modal.message = message;
                modal.status = status;
                modal.showModal = true;
                //
            }
        },
        computed: {
            title: function() {
                return modal.title;
            },
            message: function() {
                return modal.message;
            }
        },
        data: function() {
            return {

            }
        }

    });
    //экземпляр - модальное окно
    var modal = new Vue({
        el: '#modal',
        data: {
            showModal: false,
            title: 'Please, confirm action!',
            message: '',
            url: '',
            id: 0,
            status: true
        }
    });

};
