<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id');
            $table->integer('booking_id');// id dịch vụ
            $table->integer('quantity');// số lượng
            $table->bigInteger('total_price');// Tổng tiền
            $table->integer('bill_type')->nullable();// hóa đơn thu tiền làm dịch vụ hoặc thu tiền trả góp combo
            $table->integer('user_id');//id người giới thieu - để ng giới thiệu hưởng 5%
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
        Schema::dropIfExists('order_detail');
    }
}
