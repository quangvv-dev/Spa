<?php

use Illuminate\Database\Seeder;

class RulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('rules')->insert([
            'title' => 'Ví dụ 1'
        ]);
        \DB::table('rules')->insert([
            'title' => 'Ví dụ 2'
        ]);
    }
}
