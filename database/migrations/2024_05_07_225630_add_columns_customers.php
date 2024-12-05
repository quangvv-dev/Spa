<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->integer('locale_id')->nullable()->after('avatar');
            $table->dropColumn('FB_ID');
            $table->dropColumn('message');
            $table->dropColumn('page_id');
            $table->dropColumn('post_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('locale_id');
            $table->string('FB_ID')->nullable();
            $table->text('message')->nullable();
            $table->string('page_id')->nullable();
            $table->bigInteger('post_id')->nullable();
        });
    }
}
