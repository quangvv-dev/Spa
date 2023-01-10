<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePriceMkt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('price_marketings', function (Blueprint $table) {
            $table->renameColumn('number_click', 'data');
            $table->integer('invoice')->comment('tiền hoá đơn')->after('branch_id')->default(0)->nullable();
            $table->dropColumn('source_id');
            $table->dropColumn('comment');
            $table->dropColumn('message');
//            $table->

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('price_marketings', function (Blueprint $table) {
            //
        });
    }
}
