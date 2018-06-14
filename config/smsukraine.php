<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Credentials
    |--------------------------------------------------------------------------
    |
    */

    /**
     * API ключ
     */
    'api_key'    => function_exists('env') ? env('SMSUKRAINE_KEY', '') : '',

    /**
     * API логин
     */
    'api_login'    => function_exists('env') ? env('SMSUKRAINE_LOGIN', '') : '',

    /**
     * API пароль
     */
    'api_password'    => function_exists('env') ? env('SMSUKRAINE_PASSWORD', '') : '',


    /*
    |--------------------------------------------------------------------------
    | Alpha Name
    |--------------------------------------------------------------------------
    |
    | Укажите используемое для отправки альфаимя
    |
    */

    'alpha_name' => function_exists('env') ? env('SMSUKRAINE_ALPHA_NAME', '') : '',

];