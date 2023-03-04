<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupportOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id');
            $table->integer('doctor_id')->comment('id bác sĩ')->default(0)->nullable();
            $table->integer('yta1_id')->comment('id y tá 1')->default(0)->nullable();
            $table->integer('yta2_id')->comment('id y tá 2')->default(0)->nullable();
            $table->integer('support1_id')->comment('id tư vấn 1')->default(0)->nullable();
            $table->integer('support2_id')->comment('id tư vấn 2')->default(0)->nullable();
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
        Schema::dropIfExists('support_orders');
    }
}
