@extends('layouts.appvue')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Billings</div>

                    <div class="demo-grid" id="demoGrid">
                        <form class="demo-grid__search_form col-sm-6" id="search" >
                            <div class="col-sm-2">
                                <label for="form-search-input-query">Search</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="form-search-input-query" class="demo-grid__search_input form-control" name="query" v-model="searchQuery">
                            </div>
                        </form>
                        <demo-grid
                                {{--:comp_data="gridData"--}}
                                {{--:comp_paginate="paginateData"--}}
                                {{--:comp_page="page"--}}
                                :columns="gridColumns"
                                {{--:filter-key="searchQuery"--}}
                                :actions="actions"
                                :request_url="url">

                        </demo-grid>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal -->
    <div id="modal">
        <modal-component
                v-if="showModal"
                v-on:close="showModal = false"
                :componenturl="url"
                :componentstatus="status" >
        </modal-component>
    </div>

    {{--file with component templates--}}
    @include('templates.grid-paginate');



@endsection

@section('sciprts')
    @parent
    {{--<script src="js/components/grid.js"></script>--}}
    <script src="js/payments_paginate.js"></script>
@show


