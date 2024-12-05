<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('roles', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('name');
            $table->integer('department_id')->default(0)->comment('Phòng ban');
            $table->text('description')->nullable();
            $table->text('permissions')->comment('mảng quyền');
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
        Schema::dropIfExists('roles');
    }
}
