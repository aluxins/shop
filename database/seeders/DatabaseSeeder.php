<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Запустить наполнение базы данных.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            StoreSettingsSeeder::class,
            StoreAdminSeeder::class,
            //StoreDemoSeeder::class,
        ]);
    }
}
