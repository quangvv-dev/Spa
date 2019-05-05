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
            $table->string('phone')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->date('birthday')->nullable();
            $table->integer('role');
            $table->string('password')->nullable();
            $table->integer('gender');
            $table->integer('mkt_id')->nullable();//nhân viên marketing
            $table->integer('telesales_id')->nullable();// id nhân viên telesales
            $table->integer('group_id')->nullable()->default(0);// Nhóm khách hàng (khách hàng thuộc danh mục dịch vụ)
            $table->integer('source_id')->nullable()->default(0);// id nguồn khách hàng : facebook, zalo, google
            $table->integer('status_id')->nullable()->default(0);//mối quan hệ : mới, chua kết nối ...
            $table->integer('branch_id')->nullable()->default(0);// id chi nhánh
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
