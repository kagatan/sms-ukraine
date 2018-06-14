<?php

namespace Kagatan\SmsUkraine\Facades;

use Kagatan\SmsUkraine\SmsUkraineHelper;
use Illuminate\Support\Facades\Facade;

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
        return SmsUkraineHelper::class;
    }
}
