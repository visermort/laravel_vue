<script>

    require('./components/comm.vue');
    require('./components/modal.vue');
    require('./components/greed.vue');

    var GridPaginate = new Vue({
        el: '#demoGrid',
        data: {
            searchQuery: '',
            extConfig: '',
            config: {
                gridColumns: [
                    {'key': 'payment_id', 'value': 'Id'},
                    {'key': 'payment_order_id', 'value': 'Order Id', 'sort': false},
                    {'key': 'payment_summ', 'value': 'Сумма'},
                    {'key': 'payment_client_name', 'value': 'Клиент'},
                    {'key': 'payment_client_phone', 'value': 'Телефон'},
                    {'key': 'payment_status', 'value': 'Статус'},
                    {'key': 'created_at', 'value': 'Дата'}
                ],
                requestUrl: '/payments-data-paginate',
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
                        'message': 'Do you really want to delete payment?',
                        'disable': 'disable_delete'
                    }
                ],
                actionsCommon: [
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
                actionsCommonDisable: 'check_box_disable',
                perPages: [
                    {title:'15', count: 15},
                    {title:'25', count: 25},
                    {title:'50', count: 50},
                    {title:'100', count: 100}
                ],
                perPage: 15
            }
        },
        methods: {
            correctConfig: function(){
                this.extConfig = JSON.parse(document.querySelector('#grid-data-form-config').getAttribute('value'));
                for (item in this.extConfig){

                    if (this.config[item]) {
                        this.config[item] = this.extConfig[item];
                    }
                }
            }
        },
        mounted: function(){
            console.log('mounted');
            this.correctConfig();

            bus.$emit('loadconfig');
        }

    });

</script>
