<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsLocationId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('branchs', function (Blueprint $table) {
            $table->integer('location_id')->after('address')
                ->comment('1: Miền Bắc, 2: Miền Trung, 3: Miền Nam');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branchs', function (Blueprint $table) {
            //
        });
    }
}
