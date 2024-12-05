<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gifts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id')->comment('id đơn hàng)');
            $table->integer('customer_id')->comment('Khách Hàng)');
            $table->integer('product_id')->comment('ID sản phẩm');
            $table->integer('quantity')->default(0)->comment('Số lượng sản phẩm');
            $table->integer('branch_id')->nullable()->default(0)->comment('Chi nhánh');
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
        Schema::dropIfExists('gifts');
    }
}
