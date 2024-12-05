<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTableCommission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commissions', function (Blueprint $table) {
            $table->integer('payment_id');
            $table->integer('doctor')->nullable();
            $table->integer('yta1')->nullable();
            $table->integer('yta2')->nullable();
            $table->integer('support1')->nullable();
            $table->integer('support2')->nullable();


            $table->dropColumn('customer_id');
            $table->dropColumn('rose_price');
            $table->dropColumn('note');
            $table->dropColumn('user_id');
            $table->dropColumn('earn');
            $table->dropColumn('percent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commissions', function (Blueprint $table) {
            //
        });
    }
}
