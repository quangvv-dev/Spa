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
        Model::unguard();
        Department::truncate();
        Department::create(
            [
                'name'      => 'Ban giám đốc',
                'parent_id' => 0,
            ]
        );
        \App\Models\SettingCustomer::insert([
            ['name' => 'id', 'status' => false],
            ['name' => 'mkt_id', 'status' => true],
            ['name' => 'telesales_id', 'status' => true],
            ['name' => 'group_id', 'status' => true],
            ['name' => 'source_id', 'status' => true],
            ['name' => 'status_id', 'status' => true],
            ['name' => 'full_name', 'status' => true],
            ['name' => 'account_code', 'status' => true],
            ['name' => 'address', 'status' => false],
            ['name' => 'phone', 'status' => true],
            ['name' => 'birthday', 'status' => true],
            ['name' => 'gender', 'status' => true],
            ['name' => 'description', 'status' => true],
            ['name' => 'facebook', 'status' => false],
            ['name' => 'created_at', 'status' => false],
            ['name' => 'updated_at', 'status' => false],
            ['name' => 'deleted_at', 'status' => false]
        ]);
        Model::reguard();
    }
}
