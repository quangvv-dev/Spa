<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsBranchIdCustomerPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_posts', function (Blueprint $table) {
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
        Schema::table('customer_posts', function (Blueprint $table) {
            //
        });
    }
}
