<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {//Bảng chức vụ
        Schema::create('positions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('department_id')->comment('id phòng ban');
            $table->string('name')->comment('Tên chức vụ');
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
        Schema::dropIfExists('positions');
    }
}
