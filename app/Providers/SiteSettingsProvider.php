<?php

namespace App\Providers;

use App\Models\StoreSettings;
use App\Models\User;
use Database\Seeders\StoreAdminSeeder;
use Database\Seeders\StoreSettingsSeeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class SiteSettingsProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        self::StoreSettings();
    }

    /**
     * Сохранение настроек сайта в кэш.
     * @return void
     */
    public static function StoreSettings(): void
    {
        // Сохраняем настройки сайта в кэш.
        $settings = cache()->rememberForever('siteSettings', function () {
            return self::CheckMigrate()
                ? self::StoreSettingsGet()
                : false;
        });

        // Если настройки не удалось получить, удаляем siteSettings из кэша.
        if(!$settings)
            cache()->forget('siteSettings');

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
    private static function StoreSettingsGet(): array
    {
        self::StoreSeeders();

        $data = [];
        foreach (StoreSettings::select('key', 'value')->get()->toArray() as $param){
            $data[$param['key']] =
                json_decode($param['value'], true) ?? $param['value'];
        }
        return $data;
    }

    /**
     * Проверка запуска artisan migrate.
     * @return bool
     */
    private static function CheckMigrate(): bool
    {
        return Schema::hasTable('store_settings') and Schema::hasTable('users');
    }

    /**
     * Запуск наполнителей, если БД не заполнена.
     * @return void
     */
    private static function StoreSeeders(): void
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
