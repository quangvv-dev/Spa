<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->bigInteger('money_promotion');
            $table->integer('percent_promotion');
            $table->date('time_start');
            $table->date('time_end');
            $table->bigInteger('min_price');
            $table->bigInteger('max_discount');//so tien toi da dc giam theo %
            $table->bigInteger('current_quantity');// so lan su dung
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
        Schema::dropIfExists('promotions');
    }
}
