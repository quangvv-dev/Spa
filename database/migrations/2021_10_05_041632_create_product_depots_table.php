<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductDepotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_depots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('branch_id')->comment('id chi nhánh');
            $table->integer('product_id');
            $table->integer('quantity');
            $table->integer('user_id')->comment('người cập nhật');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_depots');
    }
}
