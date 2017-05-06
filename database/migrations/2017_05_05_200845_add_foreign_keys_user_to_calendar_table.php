<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysUserToCalendarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_to_calendar', function (Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('calendar_id')->references('id')->on('calendar')->onDelete('cascade');
        });
        Schema::table('calendar', function (Blueprint $table) {
            $table->foreign('boat_id')->references('id')->on('boats');
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
            $table->dropForeign('user_to_calendar_calendar_id_foreign');
        });
        Schema::table('calendar', function (Blueprint $table) {
            $table->dropForeign('calendar_boat_id_foreign');
        });
    }
}
