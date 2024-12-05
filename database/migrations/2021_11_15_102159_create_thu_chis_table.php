<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThuChisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thu_chis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('danh_muc_thu_chi_id');
            $table->bigInteger('so_tien');
            $table->integer('thuc_hien_id')->comment('người thực hiện');
            $table->integer('duyet_id')->comment('<5tr thì k cần ai duyệt')->default(0);
            $table->tinyInteger('type')->comment('0: tiền tại quầy, 1: trong két')->default(0);
            $table->boolean('status')->comment('>5tr thì phải duyệt, nhỏ hơn thì auto')->default(0);
            $table->text('note')->nullable();
            $table->integer('branch_id');
            $table->softDeletes();
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
        Schema::dropIfExists('thu_chis');
    }
}
