<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuickRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quick_replies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('page_id')->index();
            $table->text('message');
            $table->string('shortcut')->nullable();
            $table->text('images')->nullable();
            $table->integer('position')->nullable()->default(0);
            $table->integer('user_id')->nullable()->default(0);
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
        Schema::dropIfExists('quick_replies');
    }
}
