

import bus from './components/bus';

    //Vue.prototype.$http = axios; при переходе на аксиос можно так


// экземпляр - календаря
    var CalendarInstance = new Vue({
        el: '#calendar',
        data: {
            config: {
                requestUrl: '/calendar',
                dayBefore: 1,
                dayAfter: 7
                
            }
        },
        methods: {
        },
        mounted: function(){
        }

    });


