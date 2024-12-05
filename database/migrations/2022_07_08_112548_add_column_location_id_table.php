<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnLocationIdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tips', function (Blueprint $table) {
            $table->integer('location_id')->after('price')->default(0)->nullable()
                ->comment('Cụm chi nhánh');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tips', function (Blueprint $table) {
            //
        });
    }
}
