<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAchitechCampaigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->date('start_date');
            $table->date('end_date');
            $table->text('customer_status')->comment('trạng thái khách hàng');
            $table->date('from_order')->comment('Ngày phát sinh đơn hàng');
            $table->date('to_order')->comment('Ngày kết thúc phát sinh đơn hàng');
            $table->integer('branch_id')->comment('Ngày kết thúc phát sinh đơn hàng');
            $table->text('sale_id');
            $table->text('cskh');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            //
        });
    }
}
