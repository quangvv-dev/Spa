<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('approval_code');
            $table->bigInteger('all_total')->comment('tổng tiền');
            $table->text('data')->comment('bảng lương chi tiết');
            $table->integer('month');
            $table->integer('year');
            $table->integer('history_import_salary_id')->comment('lịch sử import');
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
        Schema::dropIfExists('salaries');
    }
}
