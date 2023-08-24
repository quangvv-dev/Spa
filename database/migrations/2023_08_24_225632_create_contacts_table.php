<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer_id');
            $table->string('full_name');
            $table->string('phone');
            $table->text('address')->nullable();
            $table->bigInteger('cccd')->nullable();
            $table->text('service');
            $table->integer('warranty_number')->comment('Thời gian áp dụng');
            $table->date('date')->comment('Ngày bắt đầu điều trị');
            $table->text('before')->comment('Tình trạng ban đầu');
            $table->text('after')->comment('Tình trạng sau điểu trị');
            $table->bigInteger('price');
            $table->text('result')->comment('Kết quả đạt được')->nullable();
            $table->text('warranty_time')->comment('Thời gian bảo hành')->nullable();
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
        Schema::dropIfExists('contacts');
    }
}
