<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StoreSections extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 50; $i++) {
            DB::table('store_sections')->insert([
                'name' => Str::random(10),
                'sort' => rand(1, 10),
                'parent' => rand(0, 10),
                'visible' => rand(0, 1),
                'link' => rand(0, 1),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
