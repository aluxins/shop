<?php

namespace Database\Seeders;

use App\Models\StoreSettings;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $settings = [
            'order_status' => json_encode(['created', 'approved', 'picking', 'prepared',
                                            'delivered', 'completed', 'cancelled']),
            'store_admin' => '1',

            // 'key' => 'value',
        ];

        $data = [];
        foreach ($settings as $key => $value){
            $data[] = ['key' => $key, 'value' => $value];
        }
        StoreSettings::insert($data);
    }
}
