<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandipagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landipages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->comment('tiêu đề tin');
            $table->text('content')->nullable()->comment('nội dung tin');
//            $table->string('campaign_id')->unique();
            $table->string('slug')->unique();
            $table->string('phone');
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
        Schema::dropIfExists('landipages');
    }
}
