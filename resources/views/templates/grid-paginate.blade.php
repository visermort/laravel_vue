
<!-- grid template -->
<script type="text/x-template" id="grid-template-ajax">
    <div class="grid-data">
        <div class="demo-grid__search_form col-sm-6" >
            <div class="col-sm-2">
                <label for="form-search-input-query">Search</label>
            </div>
            <div class="col-sm-8">
                <input id="form-search-input-query" class="demo-grid__search_input form-control" name="query" v-model="searchQuery" >
            </div>
            <div class="col-sm-2">
                <button class="btn btn-default demo-grid__search_button" v-on:click.prevent="getRequest()" href="#" >Search</button>
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
        <table class="grid-data__table">
            <thead class="grid-data__table_head">
            <tr>
                <th v-for="key in columns"
                    v-on:click="sortBy(key.key)" :class="{ active: sortKey == key.key }"
                >
                    @{{ key.value | capitalize }}
                    <span class="arrow" :class="sortOrders[key.key] > 0 ? 'asc' : 'dsc'"> </span>
                </th>
                <th v-if="actions.length">Actions</th>
            </tr>
            </thead>
            <tbody class="grid-data__table_body">
                <tr v-for="entry in gridData">
                    <td v-for="key in columns">
                        @{{entry[key.key]}}
                    </td>
                    <td v-if="actions.length">
                        <a class="grid-data__table_link" v-for="action in actions"
                           href=""
                           v-bind:title="action.title"
                           {{--третьим аргументом функции передали id таким образом - это первая колонка :columns = gridColumns--}}
                           v-on:click.prevent="runAction(action.action, action.method, entry[columns[0].key], action.message)"
                           v-html="action.value"
                        >
                        </a>

                    </td>
                </tr>
            </tbody>
        </table>
        <div class="grid-data__info">
            <div class="grid-data__info_text">
                Elements from @{{ paginateData.from }} to @{{ paginateData.to }}. All @{{ paginateData.total }}.
                Page @{{ paginateData.current_page }} from @{{ paginateData.last_page }}.
            </div>
        </div>
        <div class="grid-data__paginate">
            <ul class="grid-data__paginate_list">
                <li class="grid-data__paginate_item" v-for="page in paginateData.last_page">
                    <span v-if="page == dataPage" >@{{ page }}</span>
                    <a v-else v-on:click.prevent="setPage(page)" href="#" >@{{ page }}</a>
                </li>
            </ul>
        </div>



    </div>
</script>

<!-- modal -->
<div id="modal">
    <modal-component
            v-if="showModal"
            v-on:close="showModal = false"
            :component_url="url"
            :component_status="status">
    </modal-component>
</div>

<!-- template for the modal component -->
<script type="text/x-template" id="modal-template">
    <transition name="modal">
        <div class="modal-mask" v-on:click="$emit('close')" >
            <div class="modal-wrapper"  >
                <div class="modal-container modal-form" :class="{modalerror: component_status == false}" v-on:click.stop >

                    <div class="modal-form__header">
                        <div class="modal-form__header_text" >@{{ title }}</div>
                    </div>

                    <div class="modal-form__body">
                        <div class="modal-form__body_message" >@{{ message  }}</div>
                    </div>

                    <div class="modal-form__footer">
                        <button v-show="component_url" class="btn btn-default modal-form__button" v-on:click="runAction">OK</button>
                        <button class="modal-form__button btn btn-default" v-on:click="$emit('close')">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</script>