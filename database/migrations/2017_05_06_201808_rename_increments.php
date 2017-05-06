<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameIncrements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_to_calendar', function (Blueprint $table) {
            $table->dropForeign('user_to_calendar_user_id_foreign');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('user_id', 'id');
        });
        Schema::table('user_to_calendar', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });


        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_order_good_id_foreign');
        });
        Schema::table('goods', function (Blueprint $table) {
            $table->renameColumn('goods_id', 'id');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('order_good_id')->references('id')->on('goods');
        });



        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign('payments_payment_order_id_foreign');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('order_id', 'id');
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->foreign('payment_order_id')->references('id')->on('orders');
        });



        Schema::table('payments', function (Blueprint $table) {
            $table->renameColumn('payment_id', 'id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_to_calendar', function (Blueprint $table) {
            $table->dropForeign('user_to_calendar_user_id_foreign');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('id', 'user_id');
        });
        Schema::table('user_to_calendar', function (Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users');
        });



        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_order_good_id_foreign');
        });
        Schema::table('goods', function (Blueprint $table) {
            $table->renameColumn('id', 'goods_id');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('order_good_id')->references('goods_id')->on('goods');
        });



        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign('payments_payment_order_id_foreign');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('id', 'order_id');
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->foreign('payment_order_id')->references('order_id')->on('orders');
        });



        Schema::table('payments', function (Blueprint $table) {
            $table->renameColumn('id', 'payment_id');
        });
    }
}
