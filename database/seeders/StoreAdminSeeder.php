<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StoreAdminSeeder extends Seeder
{
    /**
     * Создание администратора сайта.
     */
    public function run(): void
    {
        if(User::where('email', env('MAIL_FROM_ADDRESS'))->get()->isEmpty()) {
            User::factory()->state(function () {
                return ['name' => 'admin',
                    'email' => env('MAIL_FROM_ADDRESS'),
                    'password' => Hash::make('password'),
                ];
            })->create();
        }
    }
}
