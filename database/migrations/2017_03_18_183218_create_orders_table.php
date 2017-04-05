<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('order_id');
            $table->integer('order_good_id')->unsigned();
            $table->foreign('order_good_id')->references('goods_id')->on('goods')->onDelete('cascade');
            $table->integer('order_count');
            $table->decimal('order_good_price', 10, 2);
            $table->decimal('order_summ', 10, 2);
            $table->string('order_client_name');
            $table->string('order_client_phone');
            $table->string('order_client_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
