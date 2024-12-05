<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsBranchIdGroupCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_comments', function (Blueprint $table) {
            $table->integer('branch_id')->nullable()->default(0)->index()->comment('Chi nhánh');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('group_comments', function (Blueprint $table) {
            //
        });
    }
}
