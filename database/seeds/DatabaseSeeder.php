<?php

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        \DB::table('elements')->insert([
            'title' => 'Khách hàng',
            'type'  => 'actor',
            'color' => '#4d4646'
        ]);
        \DB::table('elements')->insert([
            'title' => 'Nhân viên',
            'type'  => 'actor',
            'color' => '#5f6caf'
        ]);

        \DB::table('elements')->insert([
            'title' => 'Thêm mới',
            'type'  => 'event',
            'color' => '#40bfc1'
        ]);
        \DB::table('elements')->insert([
            'title' => 'Chỉnh sửa',
            'type'  => 'event',
            'color' => '#db3056'
        ]);
        \DB::table('elements')->insert([
            'title' => 'Thêm mới hoặc chỉnh sửa',
            'type'  => 'event',
            'color' => '#f17362'
        ]);

        \DB::table('elements')->insert([
            'title' => 'Gửi SMS',
            'type'  => 'action',
            'color' => '#ffcc00'
        ]);
        \DB::table('elements')->insert([
            'title' => 'Gửi Email',
            'type'  => 'action',
            'color' => '#be9fe1'
        ]);
        \DB::table('rules')->insert([
            'title' => 'Ví dụ 1'
        ]);
        \DB::table('rules')->insert([
            'title' => 'Ví dụ 2'
        ]);
//        Model::unguard();
//        Department::truncate();
//        Department::create(
//            [
//                'name'      => 'Ban giám đốc',
//                'parent_id' => 0,
//            ]
//        );
//        \App\Models\SettingCustomer::insert([
//            ['name' => 'id', 'status' => false],
//            ['name' => 'mkt_id', 'status' => true],
//            ['name' => 'telesales_id', 'status' => true],
//            ['name' => 'group_id', 'status' => true],
//            ['name' => 'source_id', 'status' => true],
//            ['name' => 'status_id', 'status' => true],
//            ['name' => 'full_name', 'status' => true],
//            ['name' => 'account_code', 'status' => true],
//            ['name' => 'address', 'status' => false],
//            ['name' => 'phone', 'status' => true],
//            ['name' => 'birthday', 'status' => true],
//            ['name' => 'gender', 'status' => true],
//            ['name' => 'description', 'status' => true],
//            ['name' => 'facebook', 'status' => false],
//            ['name' => 'created_at', 'status' => false],
//            ['name' => 'updated_at', 'status' => false],
//            ['name' => 'deleted_at', 'status' => false]
//        ]);
        Model::reguard();
    }
}
