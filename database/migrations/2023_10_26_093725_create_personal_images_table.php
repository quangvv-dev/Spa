<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',256)->nullable()->comment('Tên tài liệu');
            $table->string('link',256)->nullable()->comment('Đường dẫn file');
            $table->string('type_file',256)->nullable()->comment('Loại file');
            $table->date('date')->nullable()->comment('null : ảnh cá nhân, not null hiệu quả công việc ');
            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->OnDelete('cascade');
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
        Schema::dropIfExists('personal_images');
    }
}
