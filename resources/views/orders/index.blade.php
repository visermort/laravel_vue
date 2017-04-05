@extends('layouts.appvue')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Orders</div>

                    <div id="orders" class="panel-body">

                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('sciprts')
    @parent
    <script type="text/javascript" src="http://cdn.jsdelivr.net/vue.table/1.5.3/vue-table.min.js"></script>
    <script src="js/orders.js"></script>
@show


