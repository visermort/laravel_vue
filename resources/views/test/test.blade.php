@extends('layouts.appvue')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Test Viu application</div>

                    <div class="panel-body">
                        <div id="test">
                            <h4>@{{ message }}</h4>
                            <p v-bind:title="message2">
                                Подержите мышь и увидите подсказку
                            </p>
                            <p v-if="seen">Условие - если да, то это сообщение видно</p>
                            <ul>
                                <li v-for="todo in todos">
                                    @{{ todo.text }}
                                </li>
                            </ul>
                            <button v-on:click="reverseMessage">Перевернуть строку</button>
                            <p>Этот тест будет автоматически выводится из поля ввода: @{{ inputMessage }}</p>
                            <input type="text" v-model="inputMessage">
                            <div v-html="rawHtml"></div>
                            <input type="submit" v-bind:value="buttonValue">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Test Viu component todo-item</div>

                    <div id="app-7" class="panel-body">
                        <todo-item v-for="item in groceryList" :key="item.id" v-bind:todo="item"></todo-item>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('sciprts')
@parent
    <script src="js/testvue.js"></script>
@show
