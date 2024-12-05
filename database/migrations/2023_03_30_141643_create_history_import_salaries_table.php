<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryImportSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_import_salaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('tên bảng lương');
            $table->tinyInteger('status')->default(1)->comment('1:done, 0: huỷ');
            $table->integer('user_id')->comment('người tạo');
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
        Schema::dropIfExists('history_import_salaries');
    }
}
