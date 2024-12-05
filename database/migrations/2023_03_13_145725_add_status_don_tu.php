<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusDonTu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('don_tus', function (Blueprint $table) {
            $table->tinyInteger('status')->comment('=0 chưa duyệt, 1: đã duyệt, 2: không duyệt')->after('accept_id')->default(0);
            $table->date('date')->comment('ngày tạo đơn (với đơn nghỉ là từ ngày)')->change();
            $table->date('date_end')->after('accept_id')->nullable()->comment('đến ngày (đơn nghỉ)');


            $table->float('time_to')->change();
            $table->float('time_end')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('don_tus', function (Blueprint $table) {
            //
        });
    }
}
