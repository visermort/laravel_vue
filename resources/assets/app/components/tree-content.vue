<template>
    <div>
        <h3>Tree data {{ treecontent.objectTemplate ? '"'+treecontent.objectTemplate+'"' : ''}}</h3>
        <div v-if="treecontent.objectTemplate === 'good'" class="panel-content">
            <h4>Good</h4>
            <div class="row">
                <div class="col-sm-4">
                    ID
                </div>
                <div class="col-sm-8">
                    {{ treecontent.objectData.id }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    Name
                </div>
                <div class="col-sm-8">
                    {{ treecontent.objectData.goods_name }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    Price
                </div>
                <div class="col-sm-8">
                    {{ treecontent.objectData.goods_price }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    Create date
                </div>
                <div class="col-sm-8">
                    {{ treecontent.objectData.created_at }}
                </div>
            </div>
        </div>
        <div v-else-if="treecontent.objectTemplate === 'order'" class="panel-content">
            <h4>Order</h4>
            <div class="row">
                <div class="col-sm-4">
                    ID
                </div>
                <div class="col-sm-8">
                    {{ treecontent.objectData.id }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    Good Id
                </div>
                <div class="col-sm-8">
                    {{ treecontent.objectData.order_good_id }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    Good price
                </div>
                <div class="col-sm-8">
                    {{ treecontent.objectData.order_good_price }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    Count
                </div>
                <div class="col-sm-8">
                    {{ treecontent.objectData.order_count }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    Summ
                </div>
                <div class="col-sm-8">
                    {{ treecontent.objectData.order_summ }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    Client name
                </div>
                <div class="col-sm-8">
                    {{ treecontent.objectData.order_client_name }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    Client phone
                </div>
                <div class="col-sm-8">
                    {{ treecontent.objectData.order_client_phone }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    Client address
                </div>
                <div class="col-sm-8">
                    {{ treecontent.objectData.order_client_address }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    Create date
                </div>
                <div class="col-sm-8">
                    {{ treecontent.objectData.created_at }}
                </div>
            </div>
        </div>
        <div v-else-if="treecontent.objectTemplate === 'payment'" class="panel-content">
            <h4>Payment</h4>
            <div class="row">
                <div class="col-sm-4">
                    ID
                </div>
                <div class="col-sm-8">
                    {{ treecontent.objectData.id }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    Order Id
                </div>
                <div class="col-sm-8">
                    {{ treecontent.objectData.payment_order_id }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    Summ
                </div>
                <div class="col-sm-8">
                    {{treecontent. objectData.payment_summ }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    Status
                </div>
                <div class="col-sm-8">
                    {{ treecontent.objectData.payment_status }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    Client name
                </div>
                <div class="col-sm-8">
                    {{ treecontent.objectData.payment_client_name }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    Client phone
                </div>
                <div class="col-sm-8">
                    {{ treecontent.objectData.payment_client_phone }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    Create date
                </div>
                <div class="col-sm-8">
                    {{ treecontent.objectData.created_at }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import treebus from './vs-tree/treebus';

    export default {
        //name: 'content-element',
        //name: 'tree-content',
        props: {
            //treecontent: {},
            //objectData: {},
            //objectTemplate: ''
        },
        methods: {

        },
        computed: {

        },
        data: function() {
            return {
                treecontent: {
                    objectTemplate: '',
                    objectData: {}
                }


            }
        },
        mounted: function() {
            let that = this;
             treebus.$on('treeItemClick', function(data) {
                 console.log(data.data);
                 that.treecontent = data.data;
             });
        }
    }

</script>

<style>

</style>