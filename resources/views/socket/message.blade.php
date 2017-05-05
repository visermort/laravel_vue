@extends('layouts.appvue')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Test Viu application Cocket test send Message</div>

                <div class="panel-body">
                    <form action="{{ action('SocketController@sendMessage') }}" method="POST">
                       {{ csrf_field() }}
                        <div class="formgroup">
                            <input class="form-control" type="text" name="message" >

                        </div>
                        <div class="formgroup">
                            <input class="btn btn-primary" type="submit" value="send message">

                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</div>



@endsection

@section('sciprts')
@parent
{{--<script type="text/javascript" src="{{ mix('js/socket.js') }}"></script>--}}
{{--<script >--}}
    {{--var socket = io.connect('/socket');--}}
    {{--socket.on('eventClient', function (data) {--}}
        {{--console.log(data);--}}
    {{--});--}}
    {{--socket.emit('eventServer', { data: 'Hello Server' });--}}
{{--</script>--}}
@show