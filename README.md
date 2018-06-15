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

```
 'aliases' => [
    ...
    'SmsUkraine' => Kagatan\SmsUkraine\Facades\SmsUkraine::class
]
```

Для публикации провайдера и создания конфиг файла выполним:
```
php artisan vendor:publish --provider="Kagatan\SmsUkraine\SmsUkraineServiceProvider"
```


## Upgrading
 
```
composer update kagatan/sms-ukraine
```
 
## Настройка
После установки вам необходимо изменить файл `./.env` добавив ключи

```ini
SMSUKRAINE_KEY= xxxxxxxxxxxxxxxxxxxxxx

```

Если хотите использовать связку логин/пароль то добавляем след ключи:

```ini
SMSUKRAINE_LOGIN= xxxxx

SMSUKRAINE_PASSWORD= xxxxx

```
 


## Использование

Базовый пример отправки уведомления может выглядеть следующим образом:

```php

use Kagatan\SmsUkraine\Facades\SmsUkraine;

....

public function test()
{
    $id = SmsUkraine::send([
        'to'      => '38093xxxx',
        'message' => 'Demo text',
        'from'    => 'WiFi Point'
    ]);
    
    echo $id;
}
```

Доступные к использованию методы:

```php
$id = SmsUkraine::send([
    'to'      => '38093xxxx',
    'message' => 'Demo text',
    'from'    => 'WiFi Point'
]); // Отправить СМС


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