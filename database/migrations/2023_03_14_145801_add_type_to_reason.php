<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeToReason extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reasons', function (Blueprint $table) {
            $table->tinyInteger('type')->comment('0:lý do nghỉ, 1:lý do checkin')->nullable()->default(0)->after('count');
            $table->tinyInteger('phat_tien')->comment('0:không, 1: có')->after('count')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reasons', function (Blueprint $table) {
            //
        });
    }
}
