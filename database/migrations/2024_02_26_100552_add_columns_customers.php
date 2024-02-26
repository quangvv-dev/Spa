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
            $table->string('fb_name')->nullable()->comment('nghề nghiệp')->change();
            $table->text('facebook')->nullable()->comment('Tính cách khách hàng')->change();
            $table->string('numerology')->nullable()->comment('Thần số học');
            $table->string('death')->nullable()->comment('Tử huyệt');
            $table->integer('five_elements')->nullable()->comment('Ngũ hành - Mệnh');
            $table->string('job')->nullable()->comment('Nghề nghiệp');
            $table->string('interest')->nullable()->comment('Sở thích');
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
            $table->dropColumn('numerology');
            $table->dropColumn('death');
            $table->dropColumn('five_elements');
            $table->dropColumn('job');
            $table->dropColumn('interest');
        });
    }
}
