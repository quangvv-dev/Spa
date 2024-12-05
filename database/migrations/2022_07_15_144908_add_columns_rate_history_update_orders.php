<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsRateHistoryUpdateOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_update_orders', function (Blueprint $table) {
            $table->integer('rate')->nullable()->comment('Sao đánh giá');
            $table->text('comment_rate')->nullable()->comment('Đánh giá của khách hàng');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('history_update_orders', function (Blueprint $table) {
            //
        });
    }
}
