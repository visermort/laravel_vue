<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('payment_id');
            $table->integer('payment_order_id')->unsigned();
            $table->foreign('payment_order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->decimal('payment_summ', 10, 2);
            $table->string('payment_client_name');
            $table->string('payment_client_phone');
            $table->integer('payment_status');
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
        //
        Schema::drop('payments');
    }
}
