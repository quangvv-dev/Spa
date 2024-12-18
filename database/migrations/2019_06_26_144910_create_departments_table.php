<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {//bảng phòng ban
        Schema::create('departments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('Tên phòng ban');
            $table->integer('parent_id')->default(1)->comment('trực thuộc phòng ban');
            $table->text('description')->nullable()->comment('Mô tả');
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
        Schema::dropIfExists('departments');
    }
}
