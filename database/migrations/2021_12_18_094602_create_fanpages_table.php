<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFanpagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fanpages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('access_token')->comment('token page');
            $table->integer('user_id')->comment('user add fanpage')->default(0)->index();
            $table->string('page_id');
            $table->string('name');
            $table->text('avatar')->nullable();
            $table->string('role_text')->nullable();
            $table->integer('used')->comment('chấp nhận sử dụng')->default(0);
            $table->integer('source_id')->comment('nguồn')->default(0);

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
        Schema::dropIfExists('fanpages');
    }
}
