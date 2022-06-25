<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications_customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer_id')->index()->comment('Khách hàng');
            $table->string('title')->comment('Tiêu đề thông báo');
            $table->longText('data')->comment('Data');
            $table->integer('type')->comment('Loại thông báo');
            $table->integer('status')->index()->default(0)->comment('Trạng thái 0: Ẩn; 1:chưa đọc; 2: đã đọc');
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
        Schema::dropIfExists('notifications_customers');
    }
}
