<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsStatusHistoryWalletCtvTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_wallet_ctv', function (Blueprint $table) {
            $table->integer('status')->after('type')->comment('1: thành công, 0: đang chờ, 2 từ chối')
                ->default(1)->nullable();
            $table->integer('customer_id')->default(0)->nullable()->comment('Id khách hàng')->index()->change();
            $table->longText('description')->comment('Nội dung ghi chú nếu có')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('history_wallet_ctv', function (Blueprint $table) {
            //
        });
    }
}
