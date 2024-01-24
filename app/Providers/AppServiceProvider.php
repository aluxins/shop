<?php

namespace App\Providers;

use App\Models\StoreSettings;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        self::siteSettings();
    }

    public static function siteSettings(): void
    {
        $settings = cache()->rememberForever('siteSettings', function () {
            $data = [];
            foreach (StoreSettings::select('key', 'value')->get()->toArray() as $param){
                $data[$param['key']] =
                    json_decode($param['value'], true) ?? $param['value'];
            }
            return $data;
        });

        // Устанавливаем конфигурацию сайта.
        if(isset($settings['interface_locale']))Config::set('app.locale', $settings['interface_locale']);
        if(isset($settings['catalog_numberItems']))Config::set('app.store_settings.catalog.count.default', $settings['catalog_numberItems']);
        if(isset($settings['catalog_sort']))Config::set('app.store_settings.catalog.sort.default', $settings['catalog_sort']);

        View::share('siteSettings', $settings);
    }
}
