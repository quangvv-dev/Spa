<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title')->nullable()->comment('Tên voucher');
            $table->string('code');
            $table->bigInteger('money_promotion')->nullable()->comment('Số tiền khuyến mãi');
            $table->integer('percent_promotion')->nullable()->comment('% khuyến mãi');
            $table->bigInteger('min_price')->comment('Giá trị đơn tối thiểu');
            $table->bigInteger('max_discount')->comment('Số tiền tối đa giảm theo %')->nullable();//so tien toi da dc giam theo %
            $table->bigInteger('current_quantity')->comment('Số lượng voucher còn lại');// so lan su dung
            $table->integer('type')->default(1)->comment('Loai voucher 1: KM theo % , 2: theo tiền');
            $table->text('group')->nullable()->comment('Trạng thái KH');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotions');
    }
}
