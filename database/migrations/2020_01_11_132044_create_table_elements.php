<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableElements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->string('title');
            $table->string('color')->nullable();
            $table->bigInteger('parent_id')->nullable();
            $table->longText('additional_settings')->nullable();
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
        Schema::dropIfExists('elements');
    }
}
