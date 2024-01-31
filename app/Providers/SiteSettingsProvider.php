<?php

namespace App\Providers;

use App\Models\StoreSettings;
use App\Models\User;
use Database\Seeders\StoreAdminSeeder;
use Database\Seeders\StoreSettingsSeeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SiteSettingsProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Сохраняем настройки сайта в кэш.
        $settings = cache()->rememberForever('siteSettings', function () {
            self::StoreSeeders();
            return self::StoreSettingsGet();
        });

        // Устанавливаем конфигурацию сайта.
        if(isset($settings['interface_locale']))Config::set('app.locale', $settings['interface_locale']);
        if(isset($settings['catalog_numberItems']))Config::set('app.store_settings.catalog.count.default', $settings['catalog_numberItems']);
        if(isset($settings['catalog_sort']))Config::set('app.store_settings.catalog.sort.default', $settings['catalog_sort']);

        View::share('siteSettings', $settings);
    }

    /**
     * Формируем массив настроек из БД.
     * @return array
     */
    private function StoreSettingsGet(): array
    {
        $data = [];
        foreach (StoreSettings::select('key', 'value')->get()->toArray() as $param){
            $data[$param['key']] =
                json_decode($param['value'], true) ?? $param['value'];
        }
        return $data;
    }

    /**
     * Запуск наполнителей, если БД не заполнена.
     * @return void
     */
    private function StoreSeeders(): void
    {
        // Настройки сайта.
        if (StoreSettings::all()->isEmpty()){
            $seeder = new StoreSettingsSeeder;
            $seeder->run();
        }

        // Учетная запись администратора сайта.
        if (User::all()->isEmpty()){
            $seeder = new StoreAdminSeeder;
            $seeder->run();
        }
    }
}
