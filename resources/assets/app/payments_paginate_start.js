
import bus from './components/bus';

//Vue.prototype.$http = axios; при переходе на аксиос можно так

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');


// экземпляр - грид
    var demo = new Vue({
        el: '#demoGrid',
        data: {
            searchQuery: '',
            gridData: [],
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
                        'disable': 'disable_delete'//кнопка не активана условие из поля данных, сформировано в бек
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
                actionsCommonDisable: 'check_box_disable', //действия недоступны для строк - условие из поля данных
                perPages: [
                    {title:'15', count: 15},
                    {title:'25', count: 25},
                    {title:'50', count: 50},
                    {title:'100', count: 100}
                ]
                //,perPage: 15
            }

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
            },
            correctConfig: function(){
                //внешняя конфигурация - получается из бека и корректирует поля в instance
                //например columns, actions, actionCommon - позволяет загрузить одну страницу, но в зависимости 
                //от реквест корректировать грид
                var config = document.querySelector('#grid-data-form-config').getAttribute('value');
                if (config) {
                    this.extConfig = JSON.parse(config);
                    //console.log(this.extConfig);
                    for (var item in this.extConfig) {
                        if (this.config[item]) {
                            this.config[item] = this.extConfig[item];
                        }
                    }
                }
                //console.log(this.config);
            }

        },

        mounted: function() {
            console.log('mounted');
            this.correctConfig();//после загрузки страницы корректировка конфигурации
            this.getData();
        }
    });

