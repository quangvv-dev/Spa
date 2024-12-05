<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonTusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('don_tus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('type')->comment('loại đơn: 0:đơn nghỉ, 1:đơn checkin');
            $table->date('date')->comment('ngày tạo đơn');
            $table->integer('time_to')->comment('từ giờ (với đơn checkin là giờ checkin)');
            $table->integer('time_end')->comment('đến giờ')->nullable();
            $table->integer('reason_id')->comment('lý do')->index();
            $table->integer('accept_id')->comment('người duyêt')->index();
            $table->integer('user_id')->comment('người tạo đơn')->index();
            $table->text('description')->comment('mô tả')->nullable();
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
        Schema::dropIfExists('don_tus');
    }
}
