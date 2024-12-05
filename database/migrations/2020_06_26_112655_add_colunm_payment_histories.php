<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColunmPaymentHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_histories', function (Blueprint $table) {
            $table->integer('payment_type')->default(0)->after('payment_date')->comment('Kiểu thanh toán');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_histories', function (Blueprint $table) {
            //
        });
    }
}
