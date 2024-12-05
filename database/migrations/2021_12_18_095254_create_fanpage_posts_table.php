<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFanpagePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fanpage_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('access_token')->comment('token page');
            $table->bigInteger('page_id')->index();
            $table->text('title')->nullable();
            $table->text('post_id');
            $table->dateTime('post_created')->comment('ngày đăng');
            $table->integer('used')->comment('sử dụng lấy data tự động')->default(0);
            $table->integer('source_id')->default(0);
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
        Schema::dropIfExists('fanpage_posts');
    }
}
