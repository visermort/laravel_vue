
<!-- grid template -->
<script type="text/x-template" id="grid-template">
    <div class="grid-data">
        <table class="grid-data__table">
            <thead class="grid-data__table_head">
            <tr>
                <th v-for="key in columns" v-on:click="sortBy(key.key)" :class="{ active: sortKey == key.key }">
                    @{{ key.value | capitalize }}
                    <span class="arrow" :class="sortOrders[key.key] > 0 ? 'asc' : 'dsc'"> </span>
                </th>
                <th v-if="actions.length">Actions</th>
            </tr>
            </thead>
            <tbody class="grid-data__table_body">
                <tr v-for="entry in paginatedData">
                    <td v-for="key in columns">
                        @{{entry[key.key]}}
                    </td>
                    <td v-if="actions.length">
                        <a class="grid-data__table_link" v-for="action in actions"
                           href=""
                           v-bind:title="action.title"
                           {{--третьим аргументом функции передали id таким образом - это первая колонка :columns = gridColumns--}}
                           v-on:click.prevent="runAction(action.action, action.method, entry[columns[0].key], action.message)"
                           v-html="action.value">
                        </a>

                    </td>
                </tr>
            </tbody>
        </table>

        <div class="grid-data__paginate">
            <ul class="grid-data__paginate_list">
                <li class="grid-data__paginate_item" v-for="page in paginate">
                    <span v-if="page.current" >@{{ page.title }}</span>
                    <a v-else v-on:click.prevent="setPage(page.number)" href="#" >@{{ page.title }}</a>
                </li>
            </ul>
        </div>
    </div>
</script>

<!-- template for the modal component -->
<script type="text/x-template" id="modal-template">
    <transition name="modal">
        <div class="modal-mask" v-on:click="$emit('close')" >
            <div class="modal-wrapper"  >
                <div class="modal-container modal-form" :class="{modalerror: componentstatus == false}" v-on:click.stop >

                    <div class="modal-form__header">
                        <div class="modal-form__header_text" v-html="title" ></div>
                    </div>

                    <div class="modal-form__body">
                        <div class="modal-form__body_message" v-html="message"></div>
                    </div>

                    <div class="modal-form__footer">
                        <button v-show="componenturl" class="modal-form__button" v-on:click="runAction">OK</button>
                        <button class="modal-form__button" v-on:click="$emit('close')">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</script>