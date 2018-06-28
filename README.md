<p align="center">
  <img src="https://laravel.com/assets/img/components/logo-laravel.svg" alt="Laravel" width="240" />
</p>

# SMS уведомления для Laravel, сервис "SMS Ukraine"

Используя данный пакет вы сможете легко интегрировать SMS уведомления в ваше Laravel-приложение, для отправки которых используется сервис "[SMS Ukraine][smsukraine_home]".

## Установка

Для установки данного пакета выполните в терминале следующую команду:

```shell
$ composer require kagatan/sms-ukraine
```

> Для этого необходим установленный `composer`. Для его установки перейдите по [данной ссылке][getcomposer].


Если вы используете Laravel версии 5.5 и выше, то сервис-провайдер данного пакета будет зарегистрирован автоматически. В противном случае вам необходимо самостоятельно зарегистрировать сервис-провайдер в секции `providers` файла `./config/app.php`:

```php
'providers' => [
    // ...
   Kagatan\SmsUkraine\SmsUkraineServiceProvider::class,
]
```

Добавим фасад:

```php
 'aliases' => [
    ...
    'SmsUkraine' => Kagatan\SmsUkraine\Facades\SmsUkraine::class
]
```

Добавим в файл  `config/services.php` :
```php
// config/services.php
...
'sms-ukraine' => [
        'key'      => function_exists('env') ? env('SMSUKRAINE_KEY', '') : '',
        'login'    => function_exists('env') ? env('SMSUKRAINE_LOGIN', '') : '',
        'password' => function_exists('env') ? env('SMSUKRAINE_PASSWORD', '') : '',
        'from'     => function_exists('env') ? env('SMSUKRAINE_FROM', '') : '',
    ],
...
```

Для публикации провайдера:
```bash
php artisan vendor:publish --provider="Kagatan\SmsUkraine\SmsUkraineServiceProvider"
```

# Настройка
После установки вам необходимо изменить файл `./.env` добавив ключи

```ini
SMSUKRAINE_KEY=xxxxxxxxxxxxxxxxxxxxxx

SMSUKRAINE_FROM=SENDER-NAME

```

Если хотите использовать связку логин/пароль то добавляем следующие ключи:

```ini
SMSUKRAINE_LOGIN=xxxxx

SMSUKRAINE_PASSWORD=xxxxx

SMSUKRAINE_FROM=SENDER-NAME
```
 

## Upgrading
 
```
composer update kagatan/sms-ukraine
```
 
#

## Использование

Базовый пример отправки уведомления может выглядеть следующим образом:

```php

use Kagatan\SmsUkraine\Facades\SmsUkraine;

....

public function test()
{
    $id = SmsUkraine::send([
        'to'      => '38093xxxx',
        'message' => 'Example text'
    ]);
    
    echo $id;
}
```

Так же можно переопределить ключи из настроек добавив их в массив с параметрами:
```php

use Kagatan\SmsUkraine\Facades\SmsUkraine;

....

public function test()
{
    $id = SmsUkraine::send([
        'to'      => '38093xxxx',
        'message' => 'Example text 2',
        'from'    => 'SENDER',
        'key'     => 'rtWERfcgdfdBCXFBrttrtht645ujhgfRtf'
    ]);
    
    echo $id;
}
```

Доступные к использованию методы:

```php

SmsUkraine::receiveSMS($id);  // Получить статус доставки смс по ID

SmsUkraine::getBalance();  // Получить баланс

SmsUkraine::hasErrors();  // Получить кол-во ошибок

SmsUkraine::getErrors();  // Получить ошибки

SmsUkraine::getResponse();  // Получить RAW ответ запроса
```

## Лицензирование

Код данного пакета распространяется под лицензией [MIT][link_license].


[getcomposer]:https://getcomposer.org/download/
[smsukraine]:https://smsukraine.com.ua/
[link_license]:https://github.com/kagatan/sms-ukraine/blob/master/LICENSE
