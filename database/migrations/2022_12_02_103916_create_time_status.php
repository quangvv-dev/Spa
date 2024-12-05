<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('status_id')->unique();
            $table->integer('expired_time')->nullable()->default(0)->comment('thời gian cảnh báo (phút)');
            $table->integer('time_move_cskh')->nullable()->default(0)->comment('thời gian chuyển về cskh (phút)');
            $table->integer('status_id_next')->nullable()->comment('trạng thái được chuyển tiếp');
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
        Schema::dropIfExists('time_status');
    }
}
