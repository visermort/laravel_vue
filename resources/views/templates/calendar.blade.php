
<!-- calendar template -->
<script type="text/x-template" id="calendar_template">
    <div class="calendar">
        <div class="calendar-left">
            <div class="calendar-left__header">
                @{{ scrollDate }}
            </div>
            <div class="calendar-left__boats">
                <div class="calendar-boat" v-for="boatName in boatNames">
                    @{{ boatName }}
                </div>
            </div>

        </div>
        <div class="calendar-main" id="calendar-main" v-on:scroll="wrapperScroll">
            <div class="calendar-scale">
                {{--<div class="calendar-scale__item-day" v-for="itemday in timeScale" >--}}
                    {{--<div class="calendar-scale__item-day-header">--}}
                        {{--@{{ itemday.start }}--}}
                    {{--</div>--}}
                    {{--<div class="calendar-scale__item-day-content">--}}
                        {{--<div class="calendar-scale_item-hour" v-for="itemhour in itemday.hours">--}}
                            {{--<div class="calendar-scale__item-hour-header">--}}
                                {{--@{{ itemhour.start }}--}}
                            {{--</div>--}}
                            {{--<div class="calendar-scale__item-hour-content">--}}
                                {{--<div class="calendar-scale__item-quarter" v-bind:class="{now:(itemquarter === '')}" v-for="itemquarter in itemhour.quarters">--}}
                                    {{--@{{ itemquarter }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                 {{--</div>--}}
                <div class="calendar-scale__item-quarter" v-bind:class="{now:(itemquarter === '')}" v-for="itemquarter in timeScale">
                    @{{ itemquarter }}
                </div>
            </div>
            <div class="calendar-wakes">
                <div class="calendar-wakes__boat" v-for="boat in calendars">
                   <div class="calendar-wakes__interval"
                        v-bind:class="{seans:(event.type == 'seans'), now:(event.type == 'now'), past:(event.past)}"
                        v-for="event in boat"
                        v-bind:title="event.title"
                        >

                   </div>
                </div>
            </div>
        </div>


    </div>
</script>

