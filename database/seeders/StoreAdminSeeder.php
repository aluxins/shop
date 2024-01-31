<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StoreAdminSeeder extends Seeder
{
    /**
     * Создание администратора сайта.
     */
    public function run(): void
    {
        $data = [
            'name' => 'admin',
            'email' => env('MAIL_FROM_ADDRESS'),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(60),
        ];

        User::create($data);
    }
}
