@extends('layouts.appvue')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Goods tree</div>
                    <div id="goods" class="panel-body">
                        <div class="col-md-6">
                            <ul class="tree-item__list" id="tree">
                                <tree-item class="tree-item" v-for="modelparent in treeData" :model="modelparent"></tree-item>
                            </ul>
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- item template -->
    <script type="text/x-template" id="item-template">
        <li class="tree-item">
            <div class="tree_item__head">
                <span class="tree-item__node" v-bind:class="nodeClass"   v-on:click="toggle"></span>
                <span class="tree-item__title">    @{{model.id}}. @{{model.title}} </span>
            </div>
            <ul class="tree-item__list" v-show="status == 'open'">
                <tree-item class="tree-item" v-for="modelchilds in childData" :model="modelchilds"> </tree-item>
            </ul>
        </li>
    </script>



@endsection

@section('sciprts')
    @parent
    <script src="js/tree2.js"></script>
@show


