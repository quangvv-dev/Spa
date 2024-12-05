<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branchs', function (Blueprint $table) {
                $table->Increments('id');
                $table->string('name')->comment('Chi nhánh');
                $table->string('phone')->nullable()->comment('Số điện thoại');
                $table->string('address')->nullable()->comment('Địa chỉ');
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
        Schema::table('branchs', function (Blueprint $table) {
            //
        });
    }
}
