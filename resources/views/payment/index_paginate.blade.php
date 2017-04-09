@extends('layouts.appvue')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Billings</div>

                    <div class="demo-grid" id="demoGrid">
                        <grid-paginate-ajax
                                :columns="gridColumns"
                                :actions="actions"
                                :request_url="url">
                        </grid-paginate-ajax>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--file with component templates--}}
    @include('templates.grid-paginate');



@endsection

@section('sciprts')
    @parent
    {{--<script src="js/components/grid.js"></script>--}}
    <script src="js/payments_paginate.js"></script>
@show


