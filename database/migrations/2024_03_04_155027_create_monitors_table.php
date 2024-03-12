<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('owner_id')->index()->comment('Người giám sát');
            $table->date('date_check')->comment('Ngày check');
            $table->string('time')->nullable()->comment('Giờ mắc lỗi');
            $table->integer('position_id')->comment('Vị trí');
            $table->integer('classify_id')->comment('Phân loại');
            $table->integer('block_id')->comment('Khối');
            $table->integer('error_id')->comment('Lỗi');
            $table->integer('user_id')->comment('Người mắc lỗi');
            $table->bigInteger('price')->nullable()->comment('Số tiền phạt');
            $table->text('note')->nullable()->comment('Mô tả');
            $table->integer('status')->default(0)->comment('0:chờ duyệt | 1: duyệt | 2: không duyệt');
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
        Schema::dropIfExists('monitors');
    }
}
