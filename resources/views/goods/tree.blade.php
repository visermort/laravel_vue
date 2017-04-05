@extends('layouts.appvue')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Товары</div>
                    <div id="goods" class="panel-body">
                        <div class="row col-md-8 col-md-offset-2">
                            <ul class="tree" id="tree">
                                <tree-item class="tree-item" v-for="modelparent in treeData" :model="modelparent"></tree-item>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- item template -->
    <script type="text/x-template" id="item-template">
        <li>
            <div  :class="{bold: isFolder()}" v-on:click="toggle" >
                <span class="tree" v-if="isFolder()">@{{open ? '-' : '+'}}</span>
                <span class="tree" v-else>~</span>
                    @{{model.id}}. @{{model.title}}
            </div>
            <ul class="tree" v-show="open">
                <tree-item class="tree-item" v-for="modelchilds in childData" :model="modelchilds"> </tree-item>
            </ul>
        </li>
    </script>



@endsection

@section('sciprts')
    @parent
    <script src="js/tree.js"></script>
@show


