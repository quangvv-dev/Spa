<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiveMoneyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receive_money', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer_id')->index()->comment("người yêu cầu rút tiền");
            $table->bigInteger('price')->comment("Số tiền muốn rút");
            $table->longText('description')->comment("STK ngân hàng");
            $table->integer('status')->index()->comment("0: chờ duyệt; 1: duyệt; 2: Từ chối");
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
        Schema::dropIfExists('receive_money');
    }
}
