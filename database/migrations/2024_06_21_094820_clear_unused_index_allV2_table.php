<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClearUnusedIndexAllV2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_comments', function (Blueprint $table) {
            $table->index('customer_id')->change();
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->index('cskh_id')->change();
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->index('cskh_id')->change();
            $table->index('role_type')->change();
        });
        Schema::table('payment_histories', function (Blueprint $table) {
            $table->index('payment_date')->change();
        });
        Schema::table('tasks', function (Blueprint $table) {
            $table->index('customer_id')->change();
            $table->index('task_status_id')->change();
            $table->index('user_id')->change();
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
