<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveColumnFromUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('mkt_id');
            $table->dropColumn('telesales_id');
            $table->dropColumn('group_id');
            $table->dropColumn('source_id');
            $table->dropColumn('status_id');
            $table->dropColumn('account_code');
            $table->dropColumn('address');
            $table->dropColumn('description');
            $table->dropColumn('facebook');
            $table->dropColumn('birthday');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('mkt_id');
            $table->integer('telesales_id');
            $table->integer('group_id');
            $table->integer('source_id');
            $table->integer('status_id');
            $table->string('account_code');
            $table->text('address');
            $table->text('description');
            $table->string('facebook');
            $table->date('birthday');
        });
    }
}
