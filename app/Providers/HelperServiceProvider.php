<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $filenames = glob(app_path('Helpers/*.php'));

        if ($filenames !== false && is_iterable($filenames)) {
            foreach ($filenames as $filename) {
                require_once $filename;
            }
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
