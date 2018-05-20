

import vsbus from './components/vs-grid/vsbus';

import contentElement from './components/content/content.js';

    //Vue.prototype.$http = axios; при переходе на аксиос можно так


// экземпляр - грид
    let GridPaginate = new Vue({
        el: '#grid-vs',
        data: {
            searchQuery: '',
            extConfig: '',
            config: {
                gridColumns: [
                    {'key': 'id', 'value': 'Id'},
                    {'key': 'payment_order_id', 'value': 'Order Id', 'sort': false},
                    {'key': 'payment_summ', 'value': 'Сумма'},
                    {'key': 'payment_client_name', 'value': 'Клиент'},
                    {'key': 'payment_client_phone', 'value': 'Телефон'},
                    {'key': 'payment_status', 'value': 'Статус'},
                    {'key': 'created_at', 'value': 'Дата'}
                ],
                requestUrl: '/payments-data-paginate',
                requestContent: {
                    url: '/payments-data-details',
                    key: 'id'
                },
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
                ],
                perPage: 25,
                contentElement: contentElement
            }
        },
        methods: {
            correctConfig: function(){
                //внешняя конфигурация - получается из бека и корректирует поля в instance
                //например columns, actions, actionCommon - позволяет загрузить одну страницу, но в зависимости 
                //от реквест корректировать грид
                let config = document.querySelector('#grid-data-form-config').getAttribute('value');
                if (config) {
                    this.extConfig = JSON.parse(config);
                    //console.log(this.extConfig);
                    for (let item in this.extConfig) {
                        //console.log(item, this.extConfig[item]);
                        //console.log(this.config[item]);
                        if (this.config[item]) {
                            this.config[item] = this.extConfig[item];
                        }
                    }
                }
                //console.log(this.config);
            }

        },
        mounted: function(){
            console.log('mounted');
            this.correctConfig();//после загрузки страницы корректировка конфигурации
                    //после чего вызываем событие через специально сделанный ради этого экземпляр
            vsbus.$emit('loadconfig');
        }

    });


