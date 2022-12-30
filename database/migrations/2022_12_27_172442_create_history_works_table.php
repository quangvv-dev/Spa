<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_works', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('status_old')->index();
            $table->integer('status_new')->index();
            $table->integer('customer_id')->index();
            $table->text('note')->nullable();
            $table->integer('user_id')->comment('người thực hiện')->nullable()->index();
            $table->integer('type')->nullable()->default(0);
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
        Schema::dropIfExists('history_works');
    }
}
