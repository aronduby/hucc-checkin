<?php

namespace App\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Twilio\Rest\Client;

class TwilioClientProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Client::class, function($app) {
            return new Client(
                config('twilio.sid'),
                config('twilio.token'));
        });
    }

    public function provides()
    {
        return [Client::class];
    }
}
