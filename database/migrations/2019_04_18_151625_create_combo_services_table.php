<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComboServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('combo_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('service_id')->comment('mảng id service'); // mang id
            $table->integer('price'); // mang id
            $table->text('description'); // mang id
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
        Schema::dropIfExists('combo_services');
    }
}
