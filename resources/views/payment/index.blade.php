@extends('layouts.appvue')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Demo grid with paginate. Sort, search, paginage by Ajax</div>
                    <div class="">
                        <ul>
                            <li class="page-link">
                                <a href="{{ action('PaymentController@index') }}">Config in Vue instance</a>
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
                        <input type="hidden" id="grid-data-form-config"  value="{{ $config or '' }}" >
                    </div>

                    <div class="grid" id="grid-vs">

                        <vs-grid :config="config"></vs-grid>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--file with component templates--}}
    @include('templates.payments');



@endsection

@section('scripts')
    @parent
    <script type="text/javascript" src="{{ mix('js/grid.js') }}"></script>


@endsection


