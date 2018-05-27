import bus from './bus';

Vue.component('demo-grid', {
    template: '#grid-template',
    props: {
        data: Array,
        //columns: Array,
        //actions: Array,
        config: {}
    },
    data: function () {
        var sortOrders = {};
        this.config.gridColumns.forEach(function (key) {
            if (key.sort == null || key.sort) {
                sortOrders[key.key] = 1
            }
        });
        return {
            sortKey: '',
            sortOrders: sortOrders,
            paginateCount: 15,
            searchQuery: '',
            gridData: Array,
            dataPage: 1,
            checkAll: false,//выбраны все checkbox
            checkedId: [], //массив выбранных checkbox
            localPerPage: 0
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
            this.idList = [];
            if (this.dataPage > Math.ceil(this.filteredData.length / this.paginateCount)){
                this.dataPage = 1;
            }
            var start = this.paginateCount * (this.dataPage -1);
            //console.log(start)
            return this.filteredData.slice(start, start+this.paginateCount);
        },


        paginate: function(){
            var pages = [];
            for (var i = 0; i <  Math.ceil(this.filteredData.length / this.paginateCount); i++) {
                pages.push({'number' : i+1, 'title': (i+1), 'current' : (i+1) == this.dataPage});
            }
            return pages;
        },
        
        paginateInfo: function() {
            return {
                count: this.paginateCount,
                all: this.filteredData.length,
                page: this.dataPage,
                pages: Math.ceil(this.filteredData.length / this.paginateCount)
            }  
        },

        paginateButtons: function(){
            var result = [],
                pageOffset = 2,
                pageCount = Math.ceil(this.filteredData.length / this.paginateCount);
            if (!this.filteredData || pageCount == 0) {
                return result;
            } else {
                var from = this.dataPage-pageOffset > 0 ? this.dataPage-pageOffset : 1,
                    to = this.dataPage+pageOffset <= pageCount ?
                    this.dataPage+pageOffset : pageCount;
                if (this.dataPage > pageOffset + 1) {
                    result.push({title: '<<', page: 1});
                }
                if (this.dataPage > 1) {
                    result.push({title: '<', page: this.dataPage-1});
                }
                for (var i = from; i <= to; i++){
                    result.push({title: i, page: i});
                }
                if (this.dataPage < pageCount) {
                    result.push({title: '>', page: this.dataPage+1});
                }
                if (this.dataPage < pageCount - pageOffset) {
                    result.push({title: '>>', page: pageCount});
                }
            }
            return result;
        },
        idList: function() {
            var result = [];
            for (var key in this.paginatedData) {
                //console.log(this.paginatedData[key]);
                var id = this.paginatedData[key][this.config.gridColumns[0].key];
                console.log(id);
                if (!this.config.actionsCommonDisable  ||
                    !this.paginatedData[key][this.config.actionsCommonDisable] ||
                    this.paginatedData[key][this.config.actionsCommonDisable] != 1) {
                    result.push(id);
                   // console.log(this.config.actionsCommonDisable, this.paginatedData[key][this.config.actionsCommonDisable] );
                }
            }
            //console.log(result);
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
            this.sortOrders[key] = this.sortOrders[key] * -1
        },
        setPage: function (page) {
            this.dataPage = page;
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
                //console.log(this.checkedId);
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
        headerCheckClick: function () {
            console.log('headerCheckClick');
            this.checkedId = [];
            if (this.checkAll) {
                this.checkedId = this.idList;
            }
        }

    },
    mounted: function () {
        //
    }
});