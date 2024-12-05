<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCommission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id')->nullable()->index();
            $table->integer('customer_id')->nullable()->index();
            $table->text('rose_price')->nullable();
            $table->text('note')->nullable();
            $table->integer('user_id')->nullable()->index();
            $table->bigInteger('earn')->nullable();
            $table->string('percent')->nullable();
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
        Schema::dropIfExists('commissions');
    }
}
