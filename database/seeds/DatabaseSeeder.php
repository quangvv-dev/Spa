<?php

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use App\Models\Element;

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

        \DB::table('elements')->insert([
            'title' => 'Khách hàng',
            'type'  => 'actor',
            'color' => '#4d4646',
        ]);
        \DB::table('elements')->insert([
            'title' => 'Nhân viên',
            'type'  => 'actor',
            'color' => '#5f6caf',
        ]);

        \DB::table('elements')->insert([
            'title' => 'Thêm mới',
            'type'  => 'event',
            'color' => '#40bfc1',
        ]);
        \DB::table('elements')->insert([
            'title' => 'Chỉnh sửa',
            'type'  => 'event',
            'color' => '#db3056',
        ]);
        \DB::table('elements')->insert([
            'title' => 'Thêm mới hoặc chỉnh sửa',
            'type'  => 'event',
            'color' => '#f17362',
        ]);

        \DB::table('elements')->insert([
            'title' => 'Gửi SMS',
            'type'  => 'action',
            'color' => '#ffcc00',
        ]);
        \DB::table('elements')->insert([
            'title' => 'Gửi Email',
            'type'  => 'action',
            'color' => '#be9fe1',
        ]);
        \DB::table('rules')->insert([
            'title' => 'Ví dụ 1',
        ]);
        \DB::table('rules')->insert([
            'title' => 'Ví dụ 2',
        ]);
        Model::reguard();
    }
}
