import bus from './bus';


Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');

Vue.component('my-calendar', {
    template: '#calendar_template',
    props: {
        config: {}
    },
    data: function () {
        return {
            loading: false
        }
    },
    computed: {

    },
    filters: {

    },
    methods: {
        getRequest: function() {
            var data = {
                dayBefore: this.config.dayBefore,
                dayAfter: this.config.dayAfter
            };
            this.loading = true;
            //запрос
            console.log(this.config.requestUrl);
            this.$http.post(this.config.requestUrl, data).then(function(response){
                this.loading = false;
                console.log(response);
                // response.data.calendar.forEach(function(item){
                //     console.log(item, item.boat);
                // })
            }).catch(function (error) {
                this.loading = false;
                console.log(error);

            });
        }

    },
    mounted: function(){
        this.getRequest();
        //внутри функци  метод не виден, поэтому переменная
        //var func = this.setLocalPerPage;
        //ловим событие
        // bus.$on('calendarEvent', function(){
        //     console.log('После старта делаем запрос');
        //     func();//переписать perPage из конфиг
        //     //в этом месте нужно делать запрос, но поскольку он запускается при изменении localPerPage, запускать специально не нужно
        // });
    },
    watch: {

        
    }
});

