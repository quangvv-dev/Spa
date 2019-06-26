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
        Model::reguard();
    }
}
