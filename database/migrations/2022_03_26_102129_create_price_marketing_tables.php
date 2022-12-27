<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriceMarketingTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_marketings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('budget')->comment('Ngân sách')->default(0);
            $table->integer('data')->comment('Số data')->default(0);
            $table->integer('invoice')->comment('tiền hóa đơn')->default(0);
            $table->date('date')->comment('dữ liệu ngày')->nullable();
            $table->integer('user_id')->index()->comment('Người cập nhật');
            $table->integer('branch_id')->index()->comment('Chi nhánh')->default(0);
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
        Schema::dropIfExists('price_marketing');
    }
}
