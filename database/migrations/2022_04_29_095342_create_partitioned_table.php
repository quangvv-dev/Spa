<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Brokenice\LaravelMysqlPartition\Models\Partition;
use Brokenice\LaravelMysqlPartition\Schema\Schema;

class CreatePartitionedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // partitionByRange  Date
//        Schema::partitionByRange('payment_histories', 'YEAR(payment_date)', [
//            new Partition('payment_histories2018', Partition::RANGE_TYPE, 2022),
//        ], true);
//        Schema::partitionByRange('payment_wallets', 'YEAR(payment_date)', [
//            new Partition('payment_wallets2018', Partition::RANGE_TYPE, 2022),
//        ], true);
//        Schema::partitionByRange('schedules', 'YEAR(date)', [
//            new Partition('schedules2018', Partition::RANGE_TYPE, 2022),
//        ], true);
        Schema::partitionByYears('schedules', 'date', 2022);
        Schema::partitionByYears('payment_histories', 'payment_date', 2022);
        Schema::partitionByYears('payment_wallets', 'payment_date', 2022);

        Schema::partitionByRange('orders', 'UNIX_TIMESTAMP(created_at)', [
            new Partition('orders2022', Partition::RANGE_TYPE, 1640998861),
        ], true);
        Schema::partitionByRange('order_detail', 'UNIX_TIMESTAMP(created_at)', [
            new Partition('order_detail2022', Partition::RANGE_TYPE, 1640998861),
        ], true);
        Schema::partitionByRange('group_comments', 'UNIX_TIMESTAMP(created_at)', [
            new Partition('group_comments2022', Partition::RANGE_TYPE, 1640998861),
        ], true);


//        Schema::partitionByYears('orders', 'created_at', 2018);
//        Schema::partitionByYears('order_detail', 'created_at', 2018);
//        Schema::partitionByYears('group_comments', 'created_at', 2018);
        //        //End Date

//        Schema::partitionByHash('customers','phone', 100);

//        Schema::partitionByKey('orders', 100);
//        Schema::partitionByKey('order_detail', 100);
//        Schema::partitionByKey('schedules', 100);
//        Schema::partitionByKey('payment_histories', 100);
//        Schema::partitionByKey('group_comments', 1000, 'branch_id');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partitioned');
    }
}
