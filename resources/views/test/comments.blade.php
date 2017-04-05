@extends('layouts.appvue')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Тестовое приложение, получение комментариев</div>

                    <div id="app-7" class="panel-body">
                        <div class="form-group">
                            <button class="btn btn-primary" v-on:click="getCommentsItems">Получить комментарии</button>
                        </div>
                        <ul>
                            <comment-item v-for="commentItem in commentsList"  v-bind:item="commentItem"></comment-item>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('sciprts')
    @parent
    <script src="js/testvue_comments.js"></script>
@show