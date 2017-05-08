import bus from './bus';


Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');

Vue.component('my-calendar', {
    template: '#calendar_template',
    props: {
        config: {}
    },
    data: function () {
        return {
            loading: false,
            dateStart: new Date(),
            dateEnd: new Date(),
            boats: {},
            boatNames: [],
            scroll: true//запускать ли скрулл - только при загрузке
        }
    },
    computed: {
        timeScale: function(){
            var result = [], hours = [], quarters = [], day = null, dayStr = '';
            var now = new Date().getTime();
            for (var time=this.dateStart.getTime(); time < this.dateEnd.getTime(); time += (1000 * 60 * 60 * 24)) {//через 1 сутки
                //console.log(time, new Date(time));
                hours = [];
                for (var timeDay=time; timeDay < time + (1000 * 60 * 60 * 24); timeDay += (1000 * 60 * 60)) {//через 1 час
                    quarters = [];
                    for (var timeHour=timeDay; timeHour < timeDay + (1000 * 60 * 60); timeHour += (1000 * 60 * 15)) {//через 15 минут
                        if (timeHour - now <(1000 * 60 * 15) && timeHour - now >= 0 ){
                            //шкала настоящего
                            quarters.push("");//пустое значение
                        }
                        if (timeHour - now <(1000 * 60 * 15) && timeHour - now >= 0 ){
                            //шкала настоящего
                        }
                        quarters.push(new Date(timeHour).getMinutes());
                    }
                    hours.push({start: new Date(timeDay).getHours(), quarters: quarters});
                }
                result.push({start: new Date(time).toLocaleDateString(), hours: hours});
            }
            return result;
        },
        calendars: function(){
            var offset = 0,
                dateSeans = null,
                calendar = [],
                i = 0;
            var result = [];
            var now = new Date().getTime();
            for (var index in this.boats) {
                offset = new Date(this.dateStart).getTime();//отступ времени от начала
                calendar = [];
                for(var key in this.boats[index]){
                    //console.log(this.boats[index][key]);
                    dateSeans = new Date(this.boats[index][key].event_date);
                    //console.log(dateSeans);
                    for (i = offset; i < dateSeans.getTime(); i += (1000 * 60 * 15)){
                        if (i - now <(1000 * 60 * 15) && i - now >= 0 ){
                            //шкала настоящего
                            calendar.push({type: "now", now: true, past: false});
                        }
                        calendar.push({
                            type: "interval",
                            dateStart: new Date(offset),
                            past: offset < now,
                            title: offset > now ? new Date(offset) : ''
                        });
                        offset += (1000 * 60 * 15);
                    }
                    for (i = 0; i < this.boats[index][key].length; i++){
                        if (i - now <(1000 * 60 * 15) && i - now >= 0 ){
                            //шкала настоящего
                            calendar.push({type: "now", now: true, past: false});
                        }
                        calendar.push({
                            type: "seans",
                            dateStart: dateSeans,
                            passengers: this.boats[index][key].users,
                            past: offset < now,
                            title: new Date(offset)
                        });
                        offset += (1000 * 60 * 15);

                    }



                }
                for (i = offset; i < this.dateEnd.getTime(); i += (1000 * 60 * 15)){
                    if (i - now <(1000 * 60 * 15) && i - now >= 0 ){
                        //шкала настоящего
                        calendar.push({type: "now", now: true, past: false});
                    }
                    calendar.push({
                        seans: false,
                        dateStart: new Date(offset),
                        past: offset < now,
                        title: offset > now ? new Date(offset) : ''
                    });
                    offset += (1000 * 60 * 15);
                }


                result.push(calendar);
            }

            if (this.scroll) {
                //если скролл ещё не трогали, то запустим автомат скрулл
                var scrollLeft = 31 * (new Date().getTime() - this.dateStart.getTime()) / (1000 * 60 * 15);
                setTimeout(function () {
                    var wrapper = document.getElementById('calendar-main');
                    wrapper.scrollLeft = scrollLeft - wrapper.offsetWidth / 3;
                }, 2000);
            }

            return result;


        }

    },
    filters: {

    },
    methods: {
        getRequest: function() {
            var rdata = {
                dayBefore: this.config.dayBefore,
                dayAfter: this.config.dayAfter
            };
            this.loading = true;
            //запрос
            console.log(this.config.requestUrl);
            this.$http.post(this.config.requestUrl, rdata).then(function(responce){
                this.loading = false;
                console.log(responce);
                console.log(responce.data.dateStart, responce.data.dateEnd, responce.data.boats);
                this.dateStart = new Date(responce.data.dateStart);
                this.dateEnd = new Date(responce.data.dateEnd);

                this.boats = responce.data.boats;
                this.boatNames = responce.data.boatNames;

            }).catch(function (error) {
                this.loading = false;
                console.log(error);

            });

        },
        wrapperScroll: function () {
            this.scroll = false;
        }


    },
    mounted: function(){
        var load = this.getRequest;
        load();
        setInterval(function(){
            load();
        }, 10000);

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

