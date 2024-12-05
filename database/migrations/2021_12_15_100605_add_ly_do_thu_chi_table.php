<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLyDoThuChiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('thu_chis', function (Blueprint $table) {
            $table->integer('ly_do_id')->after('duyet_id')->comment('lý do thu chi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('thu_chis', function (Blueprint $table) {
            //
        });
    }
}
