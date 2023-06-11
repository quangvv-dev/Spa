<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsThefirstCallCenterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('call_center', function (Blueprint $table) {
            $table->boolean('the_first')->default(0)->nullable()->comment('cuộc gọi lỡ đầu tiên');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('call_center', function (Blueprint $table) {
            $table->dropColumn('the_first');
        });
    }
}
