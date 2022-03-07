<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSchedulesSms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules_sms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phone')->comment('số điện thoại khách hàng');
            $table->text('content')->comment('Nội dung');
            $table->dateTime('exactly_value')->nullable()->comment('Thời gian bắn tin');
            $table->integer('status')->nullable()->default(0)->comment('1: đã bắn 0: chưa bắn');
            $table->integer('status_customer')->nullable()->default(0)->comment('trạng thái khách hàng');
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
        Schema::dropIfExists('schedules_sms');
    }
}
