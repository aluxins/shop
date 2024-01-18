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
            // Имена статусов заказа
            'order_status' => json_encode(['created', 'approved', 'packing', 'prepared',
                                            'delivered', 'completed', 'cancelled']),
            // Статусы не активных заказов
            'status_inactive' => json_encode(['5', '6']),

            // ID администратора
            'store_admin' => json_encode(['1']),

            // Copyright нижнего колонтитула
            'footer_copyright' => 'Your Company, Inc. All rights reserved.',

            // WYSIWYG editor on / off
            'wysiwyg_editor' => '1',

            // Количество товаров на страницах каталога
            'catalog_numberItems' => '9',

            // Контакты компании в заголовке
            'header_contacts' => '8-800-00-00-000',

            // 'key' => 'value',
        ];

        $data = [];
        foreach ($settings as $key => $value){
            $data[] = ['key' => $key, 'value' => $value];
        }
        StoreSettings::insert($data);
    }
}
