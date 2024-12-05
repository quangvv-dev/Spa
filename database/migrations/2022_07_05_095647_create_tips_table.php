<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name')->comment('Tên thủ thuật');
            $table->integer('price')->default(0)->comment('Giá tiền thủ thuật');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('history_update_orders', function (Blueprint $table) {
            $table->integer('tip_id')->default(0)->after('support2_id')->comment('thủ thuât thực hiện')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tips');
    }
}
