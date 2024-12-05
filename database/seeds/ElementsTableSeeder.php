<?php

use Illuminate\Database\Seeder;

class ElementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
    }
}
