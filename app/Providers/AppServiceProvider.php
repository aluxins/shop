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

        $seconds = 3600;
        $settings = cache()->remember('siteSettings', $seconds, function () {
            return StoreSettings::select('key', 'value')->get()->toArray();
        });

        $data = [];
        foreach ($settings as $param){
            $data[$param['key']] =
                json_decode($param['value'], true) ?? $param['value'];
        }

        View::share('siteSettings', $data);
    }
}
