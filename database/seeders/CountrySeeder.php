<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contries')->insert([
            [
                'name' => "الامارات",
                'code' => "878",
            ],
            [
                'name' => "البحرين",
                'code' => "543",
            ],
            [
                'name' => "test",
                'code' => "111",
            ]
        ]);
    }
}
