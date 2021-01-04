<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenitivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genitives', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name')->nullable()->comment('tên nhóm tính cách');
            $table->text('description')->nullable()->comment('ghi chú');
            $table->softDeletes();
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
        Schema::dropIfExists('genitives');
    }
}
