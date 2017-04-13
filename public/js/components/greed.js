window.onload = function () {


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
        computed: {},
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
            getRequest: function () {
                var data = {};
                page: this.dataPage
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

                this.loading = true;
                this.$http.get(this.request_url, {params: data}).then(function (response) {
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
            },
            makeSeach: function () {
                this.dataPage = 1;
                this.getRequest();
            }
        },
        mounted: function () {
            this.getRequest();
        }
    });

};
