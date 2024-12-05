<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentWallets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_wallets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_wallet_id')->index()->comment('Đơn nạp');
            $table->bigInteger('price')->default(0)->comment('Số tiền thanh toán');
            $table->date('payment_date')->comment('Ngày thanh toán')->nullable();
            $table->integer('payment_type')->comment('Kiểu thanh toán')->default(0);
            $table->text('description')->comment('ghi chú')->nullable();
            $table->integer('branch_id')->index()->comment('Chi nhánh');
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
        Schema::dropIfExists('payment_wallets');
    }
}
