<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    {{--<link href="/css/app.css" rel="stylesheet">--}}
    {{--<link href="/css/style.css" rel="stylesheet">--}}
    {{--<link href="/css/font-awesome.min.css" rel="stylesheet">--}}
    @section('styles')
        <link href="{{ mix('/css/vendor.css') }}" rel="stylesheet">
        <link href="{{ mix('/css/custom.css') }}" rel="stylesheet">
    @show

    {{--<script--}}
            {{--src="https://code.jquery.com/jquery-2.2.4.min.js"--}}
            {{--integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="--}}
            {{--crossorigin="anonymous"></script>--}}

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li><a href="{{ action('GoodController@startTree') }}">Demo Tree</a></li>
                        <li><a href="{{ action('PaymentController@index') }}">Demo Grid</a></li>
                    </ul>

                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <a target="_blank" href="https://github.com/visermort/laravel_vue">See project on Github</a>
                </div>
            </div>
        </div>

        @yield('content')

    </div>
    @section('scripts')
        <script type="text/javascript" src="{{ mix('js/vendor.js') }}"></script>
    @show
</body>
</html>
