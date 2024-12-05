<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBranhIdToCommistion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commission_employees', function (Blueprint $table) {
            $table->integer('branch_id')->index();
        });
        Schema::table('support_orders', function (Blueprint $table) {
            $table->integer('branch_id')->after('support2_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commission_employees', function (Blueprint $table) {
            //
        });
    }
}
