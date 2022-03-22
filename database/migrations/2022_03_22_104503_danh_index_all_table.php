<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DanhIndexAllTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->integer('mkt_id')->index()->change();
            $table->integer('source_id')->index()->change();
            $table->integer('source_fb')->index()->change();
            $table->integer('membership')->index()->change();
            $table->integer('page_id')->index()->change();
        });
        Schema::table('schedules', function (Blueprint $table) {
            $table->integer('user_id')->index()->change();
            $table->integer('status')->index()->change();
            $table->integer('creator_id')->index()->change();
            $table->integer('person_action')->index()->change();
            $table->integer('category_id')->index()->change();
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->integer('page_id')->index()->change();

        });
        Schema::table('customers', function (Blueprint $table) {
            $table->integer('page_id')->index()->change();

        });
        Schema::table('customers', function (Blueprint $table) {
            $table->integer('page_id')->index()->change();

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
