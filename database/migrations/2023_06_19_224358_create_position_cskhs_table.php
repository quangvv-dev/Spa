<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionCskhsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('position_cskhs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('location_id')->comment('cụm chi nhánh');
            $table->integer('position')->default(0)->comment('chia tới cskh thứ bao nhiêu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('position_cskhs');
    }
}
