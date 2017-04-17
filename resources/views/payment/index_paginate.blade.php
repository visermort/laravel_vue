@extends('layouts.appvue')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Billings</div>
                    <div class="">
                        <ul>
                            <li class="page-link">
                                <a href="{{ action('PaymentController@indexPaginate') }}">Config in Vue instance</a>
                            </li>
                            <li class="page-link">
                                <a href="?config=1">Change config in backend 1</a>
                            </li>
                            <li class="page-link">
                                <a href="?config=2">Change config in backend 2</a>
                            </li>
                            <li class="page-link">
                                <a href="?config=3">Change config in backend 3</a>
                            </li>
                        </ul>
                    </div>

                    <div class="demo-grid" id="demoGrid">

                        <grid-paginate-ajax :config="config"></grid-paginate-ajax>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--file with component templates--}}
    @include('templates.grid-paginate');



@endsection

@section('scripts')
    @parent
    <script type="text/javascript" src="{{ mix('js/grid.js') }}"></script>
    {{--<script src="js/components/grid.js"></script>--}}
    {{--<script src="js/components/greed.js"></script>--}}
    {{--<script src="js/payments_paginate.js"></script>--}}

@endsection


