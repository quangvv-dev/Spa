<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('mkt_id')->comment('Nhân viên Marketing');
            $table->integer('telesales_id')->nullable()->comment('Nhân viên Telesales');
            $table->integer('group_id')->nullable()->default(0)->comment('Nhóm khách hàng (khách hàng thuộc danh mục dịch vụ)');
            $table->integer('source_id')->nullable()->default(0)->comment('id nguồn khách hàng : facebook, zalo, google');
            $table->integer('status_id')->nullable()->default(0)->comment('Mối quan hệ : mới, chua kết nối ...');
            $table->string('full_name');
            $table->string('account_code')->nullable()->comment('Mã khách hàng');
            $table->string('address')->nullable()->comment('Địa chỉ khách hàng');
            $table->string('phone')->unique();
            $table->date('birthday')->nullable();
            $table->integer('gender')->comment('0: Nữ| 1: Nam');
            $table->text('description')->nullable();
            $table->string('facebook')->nullable()->comment('Link Facebook');
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
        Schema::dropIfExists('customers');
    }
}
