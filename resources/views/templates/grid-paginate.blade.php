
<!-- grid template -->
<script type="text/x-template" id="grid-template-ajax">
    <div class="grid-data" id="grig-data">
        <input type="hidden" id="grid-data-form-config"  value="{{ $config or '' }}" >
        {{--tool bar - shown if there is actions_common--}}
        <div class="grid-data__header clearfix">
            <div class="grid-data__search_form col-sm-6" >
                <div class="col-sm-2">
                    <label for="form-search-input-query">Search</label>
                </div>
                <div class="col-sm-8">
                    <input id="form-search-input-query" class="grid-data__search_input form-control" name="query" v-model="searchQuery" >
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-default grid-data__search_button" v-on:click.prevent="makeSeach()" href="#" >Search</button>
                </div>
            </div>
            <div class="grid-data__tools col-sm-6">
                <ul class="grid-data__tools_list "  v-if="config.actionsCommon.length">
                    <li class="grid-data__tools_item"
                        v-for="action in config.actionsCommon"
                        v-bind:title="action.title"
                        v-on:click.prevent="runCommonAction(action.action, action.message)"
                        v-html="action.value" >
                    </li>
                </ul>
            </div>
        </div>
        <div class="grid-data__preloader" v-if="loading" id="fountainG">
            <div id="fountainG_1" class="fountainG"></div>
            <div id="fountainG_2" class="fountainG"></div>
            <div id="fountainG_3" class="fountainG"></div>
            <div id="fountainG_4" class="fountainG"></div>
            <div id="fountainG_5" class="fountainG"></div>
            <div id="fountainG_6" class="fountainG"></div>
            <div id="fountainG_7" class="fountainG"></div>
            <div id="fountainG_8" class="fountainG"></div>
        </div>
        {{--таблица--}}
        <table class="grid-data__table">
            <thead class="grid-data__table_head">
            <tr>
                <th class="grid-data__table-cell-checkbox" v-if="config.actionsCommon.length">
                    <input id="checkbox-table-header" type="checkbox" v-on:click="headerCheckClick" v-model="checkAll" ><label for="checkbox-table-header"></label>
                </th>
                <th  v-for="(key, index) in config.gridColumns">
                    <drop @drop="handleDrop(index, ...arguments)">
                        <drag class="grid-data__table_head-drag" :transfer-data="{moved: index}" >
                            <a class="grid-data__table_head_link"
                                v-on:click="(key.sort == null || key.sort != false ?  sortBy(key.key) : null)"
                                v-bind:class="{ active: sortKey == key.key, disable: key.sort == false }" >
                                @{{ key.value | capitalize }}
                                <span v-if="key.sort != false" class="arrow" :class="sortOrders[key.key] > 0 ? 'asc' : 'dsc'"> </span>
                            </a>
                        </drag>
                    </drop>
                </th>
                <th class="grid-data__table_head_actions" v-if="config.actions.length">Actions</th>
            </tr>
            </thead>
            <tbody class="grid-data__table_body">
                <tr v-for="entry in gridData">
                    <td class="grid-data__table-cell-checkbox" v-if="config.actionsCommon.length">
                        <input v-if="(config.actionsCommon_disable != '' && entry[config.actionsCommonDisable])"
                               v-bind:id="entry[config.gridColumns[0].key]+'_checkbox_table_row'"
                               type="checkbox" class="disabled" >
                        <input v-else
                               v-bind:id="entry[config.gridColumns[0].key]+'_checkbox_table_row'"
                               type="checkbox" v-model="checkedId"
                               v-bind:value="entry[config.gridColumns[0].key]">
                        <label v-bind:for="entry[config.gridColumns[0].key]+'_checkbox_table_row'"></label>
                    </td>
                    <td v-for="key in config.gridColumns">
                        @{{entry[key.key]}}
                    </td>
                    <td v-if="config.actions.length">
                        <ul class="grid-data__table_actions_list" >
                            <li class="grid-data__table_actions_item" v-for="action in config.actions"  >
                                <span v-if="(action.disable != null && entry[action.disable])" class="grid-data__table_actions_label"
                                      v-bind:title="action.title"
                                      v-html="action.value"
                                >
                                </span>
                                <a  v-else class="grid-data__table_actions_link"
                                   v-bind:class="{disable: (action.disable == null || entry[action.disable])}"
                                   href=""
                                   v-bind:title="action.title"
                                   {{--третьим аргументом функции передали id таким образом - это первая колонка gridColumns--}}
                                   v-on:click.prevent="runAction(action.action, action.method, entry[config.gridColumns[0].key], action.message)"
                                   v-html="action.value"
                                >
                                </a>
                            </li>
                        </ul>


                    </td>
                </tr>
            </tbody>
        </table>

        <div class="row">
            <div class="grid-data__paginate col-sm-5">
                <ul class="grid-data__paginate_list">
                    <li class="grid-data__paginate_item" v-for="page in paginateButtons">
                        <span class="grid-data__paginate_span" v-if="page.page == dataPage" >@{{ page.title }}</span>
                        <a class="grid-data__paginate_link" v-else v-on:click.prevent="setPage(page.page)" >@{{ page.title }}</a>
                    </li>
                </ul>
            </div>
            <div class="grid-data__info col-sm-4">
                <div class="grid-data__info_text">
                    Elements from @{{ paginateData.from }} to @{{ paginateData.to }}. All @{{ paginateData.total }}.
                    Page @{{ paginateData.current_page }} from @{{ paginateData.last_page }}.
                </div>
            </div>
            <div class="grid-data__per_page form-group col-sm-3">
                <div class="col-sm-6">
                    <label for="grid-data-per-page">On page</label>
                </div>
                <div class="col-sm-6">
                    <select class="grid-data__per_page_select form-control" name="per_page" id="grid-data-per-page" v-model="localPerPage" >
                        <option class="grid-data__per_page_option "
                                 v-for="option in config.perPages"
                                 v-bind:value="option.count" >
                            @{{ option.title }}
                        </option>
                    </select>
                </div>
            </div>
        </div>


    </div>
</script>

<!-- modal -->
<div id="modal">
    <modal-component
            v-if="showModal"
            v-on:close="showModal = false"
            :params="params">
    </modal-component>
</div>
