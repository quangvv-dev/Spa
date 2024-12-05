<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeToChamCong extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cham_congs', function (Blueprint $table) {
            $table->tinyInteger('type')->after('ind_red_id')->comment('0:chấm tay, 1:đơn')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cham_congs', function (Blueprint $table) {
            //
        });
    }
}
