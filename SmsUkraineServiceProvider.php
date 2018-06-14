<?php

namespace Kagatan\SmsUkraine;

use Illuminate\Support\ServiceProvider;

class SmsUkraineServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/smsukraine.php', 'smsukraine');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('smsukraine', function () {
            return new SmsUkraine();
        });

        $this->mergeConfigFrom(__DIR__ . '/config/smsukraine.php', 'smsukraine');
    }
}
