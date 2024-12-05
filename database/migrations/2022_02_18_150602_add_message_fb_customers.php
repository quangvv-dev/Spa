<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMessageFbCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('FB_ID')->comment('id người dùng')->nullable()->after('fb_name');
            $table->text('message')->comment('Nội dung tin nhắn')->nullable()->after('FB_ID');
            $table->string('page_id')->comment('id fanpage')->nullable()->after('message');
            $table->bigInteger('post_id')->comment('id nguồn bài viết')->after('page_id')->default(0);
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
            //
        });
    }
}
