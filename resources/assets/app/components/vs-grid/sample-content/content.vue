<template>

        <div class="content-element">
            <div class="content-element__left">
                <div class="content-element__left_image">
                    <img v-bind:src="('/data-images/'+contentdata.data.order.image)" alt="">
                </div>
                <div class="content-element__left_text">
                    <p>
                        {{ contentdata.data.text }}
                    </p>
                </div>
            </div>
            <div class="content-element__right">
                <div class="content-element__right_order">
                    <h4 class="content-element__right_order_header ">Order</h4>
                    <ul class="content-element__right_order_list">
                        <li class="content-element__right_order_item">
                            <div class="content-element__right_order_item_title">
                                id:
                            </div>
                            <div class="content-element__right_order_item_value">
                                {{contentdata.data.order.id}}
                            </div>
                        </li>
                        <li class="content-element__right_order_item">
                            <div class="content-element__right_order_item_title">
                                Client name:
                            </div>
                            <div class="content-element__right_order_item_value">
                                {{ contentdata.data.order.order_client_name }}
                            </div>
                        </li>
                        <li class="content-element__right_order_item">
                            <div class="content-element__right_order_item_title">
                                Client phone:
                            </div>
                            <div class="content-element__right_order_item_value">
                                {{ contentdata.data.order.order_client_phone }}
                            </div>
                        </li>
                        <li class="content-element__right_order_item">
                            <div class="content-element__right_order_item_title">
                                Client address:
                            </div>
                            <div class="content-element__right_order_item_value">
                                {{ contentdata.data.order.order_client_address }}
                            </div>
                        </li>
                        <li class="content-element__right_order_item">
                            <div class="content-element__right_order_item_title">
                                Product name:
                            </div>
                            <div class="content-element__right_order_item_value">
                                {{ contentdata.data.good.goods_name }} ({{ contentdata.data.good.id }})
                            </div>
                        </li>
                        <li class="content-element__right_order_item">
                            <div class="content-element__right_order_item_title">
                                Product price:
                            </div>
                            <div class="content-element__right_order_item_value">
                                {{ contentdata.data.order.order_good_price }}
                            </div>
                        </li>
                        <li class="content-element__right_order_item">
                            <div class="content-element__right_order_item_title">
                                Count:
                            </div>
                            <div class="content-element__right_order_item_value">
                                {{ contentdata.data.order.order_count }}
                            </div>
                        </li>
                        <li class="content-element__right_order_item">
                            <div class="content-element__right_order_item_title">
                                Order Summ:
                            </div>
                            <div class="content-element__right_order_item_value">
                                {{ contentdata.data.payment.order.order_summ }}
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="content-element__right_payments">
                    <h4 class="content-element__right_order_header">Payments</h4>
                    <ul class="content-element__right_payments_list">
                        <li class="content-element__right_payments_list" v-for="payment in contentdata.data.payments">
                            {{ payment.id }} {{ payment.created_at }} {{ payment.payment_client_name }}
                            {{ payment.payment_client_phone }} {{ payment.payment_summ }} {{paymentStatus(payment.payment_status)}} ({{ payment.payment_status }})

                        </li>
                    </ul>

                </div>
                <div class="content-element__right_status">
                    <h4 class="content-element__right_order_header">Order pay status</h4>
                    <ul class="content-element__right_payments_list">
                        <li class="content-element__right_order_item">
                            <div class="content-element__right_order_item_title">
                                Payed summ:
                            </div>
                            <div class="content-element__right_order_item_value">
                                {{ orderPayStatus.summ }}
                            </div>
                        </li>
                        <li class="content-element__right_order_item">
                            <div class="content-element__right_order_item_title">
                                Payment complete:
                            </div>
                            <div class="content-element__right_order_item_value">
                                {{ orderPayStatus.complete }}
                            </div>
                    </li>
                    </ul>
                </div>
            </div>
        </div>

</template>

<script>

    export default {
        //name: 'content-element',
        name: 'contentelement',
        props: {
            contentdata: {}
        },
        methods: {
            paymentStatus: function(statusCode) {
                if (this.contentdata.data.paymentStatuses[statusCode]) {
                    return this.contentdata.data.paymentStatuses[statusCode];
                } else {
                    return '';
                }
            },
        },
        computed: {
            orderPayStatus: function() {
                let summ = 0;
                let price = this.contentdata.data.order.order_summ;

                for (let i=0; i < this.contentdata.data.payments.length; i++) {
                    summ += this.contentdata.data.payments[i].payment_status === 1 ? this.contentdata.data.payments[i].payment_summ : 0;
                }
                return {
                    'summ': summ,
                    'complete': parseFloat(summ) >= parseFloat(price)
                }
            }

        },
        data: function() {
            return {


            }
        }
    }

</script>


<style>

    .content-element {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        justify-content: flex-start;
    }
    .content-element__left {
        text-align: center;
        max-width: 400px;
    }
    .content-element__left_image img {
        /*max-height: 200px;*/
        width: 100%;
    }
    .content-element__right_order_item {
        list-style-type: none;
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        justify-content: flex-start;
    }
    .content-element__right_order_header {
        text-align: center;
    }
    .content-element__right_order_item_title {
        width: 150px;
        text-align: right;
    }
    .content-element__right_order_item_value {
        margin-left: 20px;
        text-align: left;
    }
    .content-element__right_payments_list {
        list-style-type: none;
    }

</style>