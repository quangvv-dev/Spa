<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsPriceMkt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('price_marketings', function (Blueprint $table) {
            $table->integer('comment')->nullable()->default(0)->comment('Số lượng bình luận');
            $table->integer('message')->nullable()->default(0)->comment('Số lượng tin nhắn');
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
