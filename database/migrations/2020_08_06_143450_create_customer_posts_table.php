<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phone');
            $table->string('full_name')->comment('Tên KH');
            $table->string('note')->nullable()->comment('ghi chu');
            $table->string('post_id')->comment('bài đăng');
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
        Schema::dropIfExists('customer_posts');
    }
}
