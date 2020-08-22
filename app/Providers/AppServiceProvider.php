<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // fixes key to long
        // laravel-news.com/laravel-5-4-key-too-long-error
        Schema::defaultStringLength(191);

        // SAML urls will be generated as http without this
        URL::forceScheme('https');

        if (env('APP_ENV') === 'local') {
            unset($_SERVER['SERVER_PORT']);
        }
    }
}
