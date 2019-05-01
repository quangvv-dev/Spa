<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('category_id');
            $table->text('description')->nullable();
            $table->text('images')->nullable();
            $table->string('code')->nullable();
            $table->bigInteger('price_buy');
            $table->bigInteger('price_sell');
            $table->bigInteger('promotion_price');
            $table->string('trademark')->nullable();//thuong hieu dich vu
            $table->boolean('enable');//an hien
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
        Schema::dropIfExists('services');
    }
}
