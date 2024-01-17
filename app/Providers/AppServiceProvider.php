<?php

namespace App\Providers;

use App\Models\StoreSettings;
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
        $seconds = 3600;
        $settings = cache()->remember('siteSettings', $seconds, function () {
            $data = [];
            foreach (StoreSettings::select('key', 'value')->get()->toArray() as $param){
                $data[$param['key']] =
                    json_decode($param['value'], true) ?? $param['value'];
            }
            return $data;
        });

        View::share('siteSettings', $settings);
    }
}
