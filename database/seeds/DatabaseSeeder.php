<?php

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use App\Models\Element;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Element::truncate();
        \App\Models\Element::truncate();
        DB::table('elements')->insert([
            'title' => 'Tạo đơn',
            'type'  => 'event',
            'value'  => 'add_order',
            'color' => '#40bfc1'
        ]);
        DB::table('elements')->insert([
            'title' => 'Chuyển trang thái KH',
            'type'  => 'event',
            'value'  => 'change_relation',
            'color' => '#ff0100'
        ]);

        DB::table('elements')->insert([
            'title' => 'Nhóm dịch vụ',
            'type'  => 'actor',
            'value'  => 'customer',
            'color' => '#4d4646'
        ]);
        DB::table('elements')->insert([
            'title' => 'Trạng thái KH',
            'type'  => 'actor',
            'value'  => 'staff',
            'color' => '#5f6caf'
        ]);

//        DB::table('elements')->insert([
//            'title' => 'Thêm ',
//            'type'  => 'event',
//            'value'  => 'edit',
//            'color' => '#db3056'
//        ]);
//        DB::table('elements')->insert([
//            'title' => 'Thêm mới hoặc chỉnh sửa',
//            'type'  => 'event',
//            'value'  => 'update',
//            'color' => '#f17362'
//        ]);

        DB::table('elements')->insert([
            'title' => 'Gửi SMS',
            'type'  => 'action',
            'value'  => 'send_sms',
            'color' => '#ffcc00'
        ]);
        DB::table('elements')->insert([
            'title' => 'Gửi Email',
            'type'  => 'action',
            'value'  => 'send_email',
            'color' => '#be9fe1'
        ]);
        DB::table('elements')->insert([
            'title' => 'Tạo CV',
            'type'  => 'action',
            'value'  => 'create_job',
            'color' => '#03a9f4'
        ]);
        Model::reguard();
    }
}
