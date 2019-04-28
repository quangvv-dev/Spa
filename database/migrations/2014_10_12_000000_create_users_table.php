<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name');
            $table->string('avatar')->nullable();
            $table->string('email')->unique()->nullable();
            $table->date('birthday')->nullable();
            $table->integer('role');
            $table->string('password');
            $table->integer('gender');
            $table->integer('mkt_id')->nullable();//nguồn khach hàng
            $table->integer('status_id');//mối quan hệ : mới, chua kết nối ...
            $table->boolean('active');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
