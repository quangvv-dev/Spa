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
            $table->integer('source_id')->index()->comment('Nguồn dữ liệu');
            $table->bigInteger('budget')->comment('Ngân sách')->default(0);
            $table->integer('number_click')->comment('Số lượt click')->default(0);
            $table->date('date')->comment('dữ liệu ngày')->nullable();
            $table->integer('user_id')->index()->comment('Người cập nhật');
            $table->integer('branch_id')->index()->comment('Chi nhánh');
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
