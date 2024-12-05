<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumsViCtvTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->integer('wallet_ctv')->after('wallet')->default(0)->nullable()->comment('Ví cộng tác viên');
            $table->integer('is_gioithieu')->default(0)->nullable()->comment('id người giới thiệu');
        });

        Schema::create('history_wallet_ctv', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer_id')->default(0)->nullable()->comment('Id khách hàng');
            $table->integer('price')->default(0)->nullable()->comment('Số tiền');
            $table->integer('type')->default(0)->nullable()->comment('Loại 1: tiền hoa hồng 2: chuyển ví 3: rút tiền');
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
        Schema::table('customers', function (Blueprint $table) {
            //
        });
    }
}
