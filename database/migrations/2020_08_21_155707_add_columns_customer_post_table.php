<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsCustomerPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_posts', function (Blueprint $table) {
            $table->integer('telesales_id')->default(0)->after('post_id')->comment('Người phụ trách');
            $table->integer('status')->default(0)->comment('0: chưa gọi, 1: đã gọi , 2: đã đến');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_posts', function (Blueprint $table) {
            //
        });
    }
}
