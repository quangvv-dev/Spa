<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Hen lich lam dich vu
        Schema::create('schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->comment('id khach hang');
            $table->date('date')->comment('Ngay hen');
            $table->string('time_from')->comment('khoang gio som nhat');
            $table->string('time_to')->comment('khoang gio som nhat');
            $table->integer('creator_id')->comment('Nhân viên tạo');
            $table->text('note')->comment('ghi chu');
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
        Schema::dropIfExists('schedules');
    }
}
