window.onload = function () {

    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');

// register the grid component
    Vue.component('grid-paginate-ajax', {
        template: '#grid-template-ajax',
        props: {
            columns: Array,
            actions: Array,
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
                loading: false
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
            getRequest: function() {
                var data = {
                    page: this.dataPage,
                    sort: this.sortKey,
                    dir: this.sortOrders[this.sortKey],
                    search: this.searchQuery
                };
                this.loading = true;
                this.$http.get(this.request_url, {params: data}).then(function(response){
                    this.loading = false;
                    console.log(response);
                    this.gridData = response.data.payments.data;
                    //console.log(response.data);
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
                    //console.log(this.gridData, this.paginateData);
                }).catch(function (error) {
                    this.loading = false;
                    console.log(error);
                });
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
            gridColumns: [
                {'key':'payment_id', 'value': 'Id'},
                {'key':'payment_order_id', 'value': 'Order Id'},
                {'key':'payment_summ', 'value': 'Сумма'},
                {'key':'payment_client_name', 'value': 'Клиент'},
                {'key':'payment_client_phone', 'value': 'Телефон'},
                {'key':'payment_status', 'value': 'Статус'},
                {'key':'created_at', 'value': 'Дата'}
            ],
            url: '/payments-data-paginate',
            actions: [
                {
                    'value': '<i class="fa fa-pencil" aria-hidden="true"></i>',
                    'title': 'Edit payment',
                    'action': '/payments/edit/',
                    'method': 'get'
                },
                {
                    'value': '<i class="fa fa-trash" aria-hidden="true"></i>',
                    'title': 'Delete payment',
                    'action': '/payments/delete',
                    'method': 'post',
                    'message': 'Do you really want to delete payment?'
                }
            ]
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
