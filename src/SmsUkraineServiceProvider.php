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
       //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('smsukraine', function () {
            return new SmsUkraine(config('services.sms-ukraine'));
        });
    }
}
