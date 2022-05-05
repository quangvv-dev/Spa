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
        Schema::partitionByRange('payment_histories', 'YEAR(payment_date)', [
            new Partition('payment_histories2019', Partition::RANGE_TYPE, 2019),
            new Partition('payment_histories2020', Partition::RANGE_TYPE, 2020),
            new Partition('payment_histories2021', Partition::RANGE_TYPE, 2021),
            new Partition('payment_histories2022', Partition::RANGE_TYPE, 2022),
            new Partition('payment_histories2023', Partition::RANGE_TYPE, 2023),
            new Partition('payment_histories2024', Partition::RANGE_TYPE, 2024),
            new Partition('payment_histories2025', Partition::RANGE_TYPE, 2025),
            new Partition('payment_histories2026', Partition::RANGE_TYPE, 2026),
        ], true);
        Schema::partitionByRange('payment_wallets', 'YEAR(payment_date)', [
            new Partition('payment_wallets2019', Partition::RANGE_TYPE, 2019),
            new Partition('payment_wallets2020', Partition::RANGE_TYPE, 2020),
            new Partition('payment_wallets2021', Partition::RANGE_TYPE, 2021),
            new Partition('payment_wallets2022', Partition::RANGE_TYPE, 2022),
            new Partition('payment_wallets2023', Partition::RANGE_TYPE, 2023),
            new Partition('payment_wallets2024', Partition::RANGE_TYPE, 2024),
            new Partition('payment_wallets2025', Partition::RANGE_TYPE, 2025),
            new Partition('payment_wallets2026', Partition::RANGE_TYPE, 2026),
        ], true);
        Schema::partitionByRange('schedules', 'YEAR(date)', [
            new Partition('schedules2019', Partition::RANGE_TYPE, 2019),
            new Partition('schedules2020', Partition::RANGE_TYPE, 2020),
            new Partition('schedules2021', Partition::RANGE_TYPE, 2021),
            new Partition('schedules2022', Partition::RANGE_TYPE, 2022),
            new Partition('schedules2023', Partition::RANGE_TYPE, 2023),
            new Partition('schedules2024', Partition::RANGE_TYPE, 2024),
            new Partition('schedules2025', Partition::RANGE_TYPE, 2025),
            new Partition('schedules2026', Partition::RANGE_TYPE, 2026),
        ], true);
//        Schema::partitionByYears('schedules', 'date', 2022);
//        Schema::partitionByYears('payment_histories', 'payment_date', 2022);
//        Schema::partitionByYears('payment_wallets', 'payment_date', 2022);

//        Schema::partitionByRange('orders', 'UNIX_TIMESTAMP(created_at)', [
//            new Partition('orders2022', Partition::RANGE_TYPE, 1640998861),
//        ], true);
        Schema::partitionByRange('order_detail', 'UNIX_TIMESTAMP(created_at)', [
            new Partition('order_detail2019', Partition::RANGE_TYPE, 1546275601),
            new Partition('order_detail2020', Partition::RANGE_TYPE, 1577811601),
            new Partition('order_detail2021', Partition::RANGE_TYPE, 1609434001),
            new Partition('order_detail2022', Partition::RANGE_TYPE, 1640970001),
            new Partition('order_detail2023', Partition::RANGE_TYPE, 1672506001),
            new Partition('order_detail2024', Partition::RANGE_TYPE, 1704042001),
            new Partition('order_detail2025', Partition::RANGE_TYPE, 1735664401),
            new Partition('order_detail2026', Partition::RANGE_TYPE, 1767200401),
        ], true);
        Schema::partitionByRange('group_comments', 'UNIX_TIMESTAMP(created_at)', [
            new Partition('group_comments2019', Partition::RANGE_TYPE, 1546275601),
            new Partition('group_comments2020', Partition::RANGE_TYPE, 1577811601),
            new Partition('group_comments2021', Partition::RANGE_TYPE, 1609434001),
            new Partition('group_comments2022', Partition::RANGE_TYPE, 1640970001),
            new Partition('group_comments2023', Partition::RANGE_TYPE, 1672506001),
            new Partition('group_comments2024', Partition::RANGE_TYPE, 1704042001),
            new Partition('group_comments2025', Partition::RANGE_TYPE, 1735664401),
            new Partition('group_comments2026', Partition::RANGE_TYPE, 1767200401),
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
