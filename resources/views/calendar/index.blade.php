@extends('layouts.appvue')

@section('styles')
    @parent
    <link href="{{ mix('/css/timeline.css') }}" rel="stylesheet">
@endsection


@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Calendar</div>
                    <div class="calendar-wrapper" id="calendar">
                        <my-calendar
                                :config="config" >
                        </my-calendar>
                    </div>


                </div>
            </div>
        </div>
    </div>

    {{--file with component templates--}}
    @include('templates.calendar');



@endsection

@section('scripts')
    @parent
    <script type="text/javascript" src="{{ mix('js/calendar.js') }}"></script>


@endsection


