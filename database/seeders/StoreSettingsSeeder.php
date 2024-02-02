<?php

namespace Database\Seeders;

use App\Models\StoreSettings;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSettingsSeeder extends Seeder
{
    /**
     * Наполнение БД StoreSettings (настройки сайта).
     */
    public function run(): void
    {
        // Отчистка кэша siteSettings
        cache()->forget('siteSettings');

        // Отчиска БД.
        StoreSettings::query()->truncate();

        $settings = [
            // Имена статусов заказа
            'order_status' => [ 'value' => json_encode(['created', 'approved', 'packing', 'prepared',
                                                        'delivered', 'completed', 'cancelled']),
                                'options' => 'array'],
            /*
            // Статусы не активных заказов
            'status_inactive' => [  'value' => json_encode(['5', '6']),
                                    'options' => 'array'],
            */

            // ID администратора
            'store_admin' => [  'value' => json_encode(['1']),
                                'options' => 'array'],

            // WYSIWYG editor on / off
            'wysiwyg_editor' => [   'value' => '1',
                                    'options' => 'boolean'],

            // Язык интерфейса
            'interface_locale' => [ 'value' => 'en',
                'options' => 'enum:en,ru'],

            // Количество товаров на страницах каталога по умолчанию
            'catalog_numberItems' => [  'value' => config('app.store_settings')['catalog']['count']['default'],
                                        'options' => 'enum:' . implode(',', config('app.store_settings')['catalog']['count']['values'])],

            // Сортировка товаров по умолчанию
            'catalog_sort' => [ 'value' => config('app.store_settings')['catalog']['sort']['default'],
                                'options' => 'enum:' . implode(',', config('app.store_settings')['catalog']['sort']['values'])],

            // Контакты компании в заголовке
            'header_contacts' => [  'value' => '8-800-00-00-000',
                                    'options' => 'string'],

            // Copyright нижнего колонтитула
            'footer_copyright' => [ 'value' => 'Your Company, Inc. All rights reserved.',
                'options' => 'string'],

            // Валюта
            'currency_icon' => [  'value' => '&#36;',
                'options' => 'enum:&#36;,&#8381;,&euro;'],

            // 'key' => ['value' => '...', 'options' => '...'],
        ];

        $data = [];
        foreach ($settings as $key => $value){
            $data[] = ['key' => $key, 'value' => $value['value'], 'options' => $value['options']];
        }
        StoreSettings::insert($data);
    }
}
