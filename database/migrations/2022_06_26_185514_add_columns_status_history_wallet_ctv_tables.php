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
            $table->integer('status')->after('type')->comment('Trạng thái thành công hay thất bại')
                ->default(1)->nullable();
            $table->integer('customer_id')->default(0)->nullable()->comment('Id khách hàng')->index()
                ->change();
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
