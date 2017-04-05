@extends('layouts.appvue')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Товары</div>

                    <div id="goods" class="panel-body">
                        <div class="row col-md-8 col-md-offset-2">
                            <ul>
                                <good-item v-for="goodItem in list"  v-bind:item="goodItem"></good-item>
                            </ul>
                        </div>
                        <div class="row col-md-8 col-md-offset-2">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label for="name">Название</label>
                                <input class="form-control" type="text" id="name" v-model="inputs.name" >
                                <span v-if="errors['name']" class="error">@{{ errors['name'] }}</span>
                            </div>
                            <div class="form-group">
                                <label for="price">Цена</label>
                                <input class="form-control" type="text" id="price" v-model="inputs.price" >
                                <span v-if="errors['price']" class="error">@{{ errors['price'] }}</span>

                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" v-on:click="goodAdd">Добавать товар</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('sciprts')
    @parent
    <script src="js/goods.js"></script>
@show


