@extends('layouts.appvue')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Goods tree</div>

                    {{--экземпляр tree--}}
                    <div class="panel-body">
                        <div class="col-md-6" id="tree">

                            <vs-tree :url="url"> </vs-tree>

                        </div>
                        <div class="col-md-6" id="tree-content">

                            <treecontent> </treecontent>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('scripts')
    @parent
    {{--<script src="js/tree2.js"></script>--}}
    <script type="text/javascript" src="{{ mix('js/tree.js') }}"></script>
@endsection


