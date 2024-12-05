<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistorySmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_sms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phone')->index()->comment('sđt');
            $table->integer('campaign_id')->index()->comment('chiến dịch');
            $table->text('message')->comment('nội dung tin nhắn');
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
        Schema::dropIfExists('history_sms');
    }
}
