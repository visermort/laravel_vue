window.onload = function () {

    // function include(url) {
    //     var script = document.createElement('script');
    //     script.src = url;
    //     document.getElementsByTagName('head')[0].appendChild(script);
    // }
    // include('js/components/grid.js');

    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');

// register the grid component
    Vue.component('demo-grid', {
        template: '#grid-template',
        props: {
            data: Array,
            columns: Array,
            actions: Array
        },
        data: function () {
            var sortOrders = {};
            this.columns.forEach(function (key) {
                sortOrders[key.key] = 1
            });
            return {
                sortKey: '',
                sortOrders: sortOrders,
                page: 1,
                paginateCount: 10,
                searchQuery: ''
            }
        },
        computed: {
            filteredData: function () {

                var sortKey = this.sortKey;
                var filterKey = this.searchQuery && this.searchQuery.toLowerCase();
                var order = this.sortOrders[sortKey] || 1;
                var data = this.data;
                if (filterKey) {
                    data = data.filter(function (row) {
                        return Object.keys(row).some(function (key) {
                            return String(row[key]).toLowerCase().indexOf(filterKey) > -1
                        })
                    })
                }
                if (sortKey) {
                    data = data.slice().sort(function (a, b) {
                        a = a[sortKey];
                        b = b[sortKey];
                        return (a === b ? 0 : a > b ? 1 : -1) * order
                    })
                }
                return data
            },

            paginatedData: function() {
                if (this.page > Math.ceil(this.filteredData.length / this.paginateCount)){
                    this.page = 1;
                }
                var start = this.paginateCount * (this.page -1);
                console.log(start);
                return this.filteredData.slice(start, start+this.paginateCount);
            },

            paginate: function(){
                var pages = [];
                for (var i = 0; i <  Math.ceil(this.filteredData.length / this.paginateCount); i++) {
                    pages.push({'number' : i+1, 'title': (i+1), 'current' : (i+1) == this.page});
                }
                return pages;
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
                this.sortOrders[key] = this.sortOrders[key] * -1
            },
            setPage: function (page) {
                this.page = page;
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
            }

        }
    });

// экземпляр - грид
    var demo = new Vue({
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
            gridData: [],
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

        },
        methods: {
            getData : function() {

                this.$http.get('/payments-data').then(function(response){
                    console.log(response.data.payments);
                    this.gridData = response.data.payments;
                    //colsole.log(this.greedData)
                }).catch(function (error) {
                    console.log(error);
                });
            }

        },

        mounted: function() {

            this.getData();
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
