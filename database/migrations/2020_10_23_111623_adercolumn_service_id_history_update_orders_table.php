<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdercolumnServiceIdHistoryUpdateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_update_orders', function (Blueprint $table) {
            $table->integer('service_id')->default(0)->after('order_id')->comment('ID dich vu');
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
