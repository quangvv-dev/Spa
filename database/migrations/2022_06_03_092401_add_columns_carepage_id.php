<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsCarepageId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->integer('carepage_id')->after('mkt_id')->index()->nullable()->default(0);
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('carepage_id')->after('owner_id')->index()->nullable()->default(0);
            $table->integer('mkt_id')->index()->nullable()->default(0);
            $table->integer('telesale_id')->index()->nullable()->default(0);
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
