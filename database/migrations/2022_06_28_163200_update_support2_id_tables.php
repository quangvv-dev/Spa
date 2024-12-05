<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSupport2IdTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_update_orders', function (Blueprint $table) {
            $table->integer('support2_id')->after('support_id')->comment('người trợ giúp 2')->nullable();
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
