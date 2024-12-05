<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('type')->comment('Loại kết nối, fb, zalo ..')->default(1);
            $table->text('name');
            $table->integer('chanel')->comment('kênh quảng cáo')->default(1);
            $table->text('category_id')->comment('nhóm dịch vụ');
            $table->text('sale_id')->comment('mảng id sale phụ trách')->nullable();
            $table->tinyInteger('accept')->comment('duyệt')->default(0);
            $table->integer('mkt_id')->comment('người tạo');
            $table->integer('position')->comment('chia data đến vị trí')->default(0);
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
        Schema::dropIfExists('sources');
    }
}
