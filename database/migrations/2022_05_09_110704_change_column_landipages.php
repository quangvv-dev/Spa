<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnLandipages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('landipages', function (Blueprint $table) {
//            $table->integer('active')->index()->default(1)->change();
//            $table->text('thumbnail')->change();
            $table->integer('position')->index()->default(0)->after('active')->comment('Tin nổi bật');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('landipages', function (Blueprint $table) {
            //
        });
    }
}
