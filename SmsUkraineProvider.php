<?php

namespace Kagatan\SmsUkraine;

use Illuminate\Support\ServiceProvider;

class SmsUkraineProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom( __DIR__.'/config/smsukraine.php', 'smsukraine');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom( __DIR__.'/config/smsukraine.php', 'smsukraine');
    }
}
