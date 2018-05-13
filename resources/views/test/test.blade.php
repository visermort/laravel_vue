@extends('layouts.appvue')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Test application</div>

                    <div class="panel-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        var user = {
            firstName: "Вася",
            sayHi: function() {
                for (var i=0; i < arguments.length; i++)
                console.log(this.firstName + ' says: Hi, ' + arguments[i]);
            }
        };

        //setTimeout(user.sayHi, 1000); // undefined (не Вася!)
        setTimeout(function(){
            user.sayHi('Петя');//Вася
            user.sayHi('Марина');//Вася
        }, 1000);
        console.log('start');

        var b = user.sayHi.bind(user, 'Bind', 'Коля', 'Максим', 'Лена');
        setTimeout(b, 2000);


    </script>



@endsection

@section('sciprts')
@parent

@show
