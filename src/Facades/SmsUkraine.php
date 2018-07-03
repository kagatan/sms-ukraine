<?php

namespace Kagatan\SmsUkraine\Facades;

use Illuminate\Support\Facades\Facade;
use Kagatan\SmsUkraine\SmsUkraineClient;

class SmsUkraine extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return SmsUkraineClient::class;
    }
}
