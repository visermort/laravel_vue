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
                            <div v-if="objectsTemplate === 'good'" class="panel-content">
                                <h4>Good</h4>
                                <div class="row">
                                    <div class="col-sm-4">
                                        ID
                                    </div>
                                    <div class="col-sm-8">
                                        @{{ objectsData.goods_id }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        Name
                                    </div>
                                    <div class="col-sm-8">
                                        @{{ objectsData.goods_name }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        Price
                                    </div>
                                    <div class="col-sm-8">
                                        @{{ objectsData.goods_price }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        Create date
                                    </div>
                                    <div class="col-sm-8">
                                        @{{ objectsData.created_at }}
                                    </div>
                                </div>
                            </div>
                            <div v-else-if="objectsTemplate === 'order'" class="panel-content">
                                <h4>Order</h4>
                                <div class="row">
                                    <div class="col-sm-4">
                                        ID
                                    </div>
                                    <div class="col-sm-8">
                                        @{{ objectsData.order_id }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        Good Id
                                    </div>
                                    <div class="col-sm-8">
                                        @{{ objectsData.order_good_id }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        Good price
                                    </div>
                                    <div class="col-sm-8">
                                        @{{ objectsData.order_good_price }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        Count
                                    </div>
                                    <div class="col-sm-8">
                                        @{{ objectsData.order_count }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        Summ
                                    </div>
                                    <div class="col-sm-8">
                                        @{{ objectsData.order_summ }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        Client name
                                    </div>
                                    <div class="col-sm-8">
                                        @{{ objectsData.order_client_name }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        Client phone
                                    </div>
                                    <div class="col-sm-8">
                                        @{{ objectsData.order_client_phone }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        Client address
                                    </div>
                                    <div class="col-sm-8">
                                        @{{ objectsData.order_client_address }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        Create date
                                    </div>
                                    <div class="col-sm-8">
                                        @{{ objectsData.created_at }}
                                    </div>
                                </div>
                            </div>
                            <div v-else-if="objectsTemplate === 'payment'" class="panel-content">
                                <h4>Payment</h4>
                                <div class="row">
                                    <div class="col-sm-4">
                                        ID
                                    </div>
                                    <div class="col-sm-8">
                                        @{{ objectsData.payment_id }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        Order Id
                                    </div>
                                    <div class="col-sm-8">
                                        @{{ objectsData.payment_order_id }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        Summ
                                    </div>
                                    <div class="col-sm-8">
                                        @{{ objectsData.payment_summ }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        Status
                                    </div>
                                    <div class="col-sm-8">
                                        @{{ objectsData.payment_status }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        Client name
                                    </div>
                                    <div class="col-sm-8">
                                        @{{ objectsData.payment_client_name }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        Client phone
                                    </div>
                                    <div class="col-sm-8">
                                        @{{ objectsData.payment_client_phone }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        Create date
                                    </div>
                                    <div class="col-sm-8">
                                        @{{ objectsData.created_at }}
                                    </div>
                                </div>
                            </div>

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
                <div class="tree-item__node" v-bind:class="nodeClass"   v-on:click="toggle"></div>
                <div class="tree-item__title">
                    <a  v-if="model.href" v-bind:href="model.href" v-on:click.prevent="getObject(model.href)">
                        @{{model.id}}. @{{model.title}}
                    </a>
                    <span v-else class="tree-item__title">@{{model.id}}. @{{model.title}}</span>
                </div>
            </div>
            <ul class="tree-item__list" v-show="status == 'open'">
                <tree-item class="tree-item" v-for="modelchilds in childData" :model="modelchilds"> </tree-item>
            </ul>
        </li>
    </script>



@endsection

@section('scripts')
    @parent
    {{--<script src="js/tree2.js"></script>--}}
    <script type="text/javascript" src="{{ mix('js/tree.js') }}"></script>
@endsection


