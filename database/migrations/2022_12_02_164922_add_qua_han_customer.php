<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuaHanCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dateTime('expired_time')->nullable()->comment('thời gian quá hạn');
            $table->dateTime('time_move_cskh')->nullable()->comment('thời gian chuyển về cskh');
            $table->tinyInteger('expired_time_boolean')->nullable()->default(0)->comment('0:chưa quá hạn,1:đã quá hạn,2:chuyển về cskh');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            //
        });
    }
}
