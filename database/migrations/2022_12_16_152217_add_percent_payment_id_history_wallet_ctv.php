<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPercentPaymentIdHistoryWalletCtv extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_wallet_ctv', function (Blueprint $table) {
            $table->integer('percent')->default(0)->nullable();
            $table->bigInteger('payment_history_id');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->integer('type_ctv')->after('is_gioithieu')->default(0)->nullable();
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
