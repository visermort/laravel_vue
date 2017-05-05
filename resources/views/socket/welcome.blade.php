@extends('layouts.appvue')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Test Viu application Cocket test</div>

                <div class="panel-body">
                    <div id="messages">

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



@endsection

@section('sciprts')
@parent
{{--<script type="text/javascript" src="{{ mix('js/socket-client.js') }}"></script>--}}
<script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>

<script>
    var socket = io.connect('http://localhost:8890');
    socket.on('message', function (data) {
        $( "#messages" ).append( "<p>"+data+"</p>" );
    });
</script>
@show