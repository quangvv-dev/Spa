<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCallCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_center', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('caller_id')->comment('ID cuộc gọi');
            $table->string('call_type')->nullable()->comment('Gọi đến hay gọi đi');
            $table->dateTime('start_time')->comment('thời gian gọi');
            $table->string('caller_number')->index()->comment('nguời gọi');
            $table->string('dest_number')->index()->comment('nguời nghe máy');
            $table->integer('answer_time')->nullable()->comment('Thời gian đàm thoại');
            $table->string('call_status')->comment('Trạng thái cuộc gọi');
            $table->text('recording_url')->nullable()->comment('File ghi âm');
//            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('call_center.phps');
    }
}
