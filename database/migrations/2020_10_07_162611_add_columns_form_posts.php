<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsFormPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->text('form_html')->nullable()->after('title')->comment('HTML FORM');
            $table->text('setting_form')->nullable()->after('form_html')->comment('Style css form');
            $table->text('sale_id')->nullable()->after('setting_form')->comment('array sale nhan khach');
            $table->integer('position')->default(0)->after('sale_id')->comment('thứ tự sale nhận khách');
            $table->text('group')->nullable()->after('position')->comment('Nhóm khách hàng');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            //
        });
    }
}
