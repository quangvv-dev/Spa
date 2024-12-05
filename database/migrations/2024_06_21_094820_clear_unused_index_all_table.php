<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClearUnusedIndexAllTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex('customers_genitive_id_index');
            $table->dropIndex('customers_membership_index');
        });
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropIndex('schedules_category_id_index');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_email_unique');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('orders_owner_id_index');
        });
        Schema::table('order_detail', function (Blueprint $table) {
            $table->dropIndex('order_detail_user_id_index');
        });
        Schema::table('commissions', function (Blueprint $table) {
            $table->dropIndex('commissions_customer_id_index');
        });
        Schema::table('customer_posts', function (Blueprint $table) {
            $table->dropIndex('customer_posts_branch_id_index');
        });
        Schema::table('price_marketings', function (Blueprint $table) {
            $table->dropIndex('price_marketings_branch_id_index');
            $table->dropIndex('price_marketings_user_id_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
