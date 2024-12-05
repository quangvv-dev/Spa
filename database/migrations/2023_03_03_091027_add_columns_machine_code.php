<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsMachineCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('branchs', function (Blueprint $table) {
            $table->string('name_machine')->nullable()->after('location_id')->comment('Mã máy chấm công chi nhánh');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branchs', function (Blueprint $table) {
            //
        });
    }
}
