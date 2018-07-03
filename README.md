<p align="center">
  <img src="https://laravel.com/assets/img/components/logo-laravel.svg" alt="Laravel" width="240" />
</p>

# Канал уведомлений для сервиса "SMS Ukraine"

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
   Kagatan\SmsUkraineClient\SmsUkraineServiceProvider::class,
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
 
## Использование

Базовый пример отправки SMS уведомлений с использованием функционала нотификаций в Laravel-приложениях:


Доступные к использованию методы у объекта SmsUkraineMessage:

Имя метода  | Описание
----------- | --------
`from()`    | Имя отправителя (опционально)
`to()`      | Номер телефона получателя (опционально)
`content()` | Текст сообщения
`sendAt()`  | Дата доставки (опционально)
`key()`     | API ключ, для переопределения параметров из config(опционально)
`login()`   | API логин, для переопределения параметров из config(опционально)
`password()`| API пароль, для переопределения параметров из config(опционально)
`toJson()`  | Обьект на выходе в JSON
`toArray()` | Объект на выходе в массиве



Пример класса оповещения:

```php
<?php

use Illuminate\Notifications\Notification;
use Kagatan\SmsUkraine\SmsUkraineChannel;
use Kagatan\SmsUkraine\SmsUkraineMessage;

/**
 * Notification object.
 */
class InvoicePaid extends Notification
{
    /**
     * Get the notification channels.
     *
     * @param mixed $notifiable
     *
     * @return array|string
     */
    public function via($notifiable)
    {
        return [SmsUkraineChannel::class];
    }

    /**
     * Get the SMS Ukraine Message representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return SmsUkraineMessage
     */
    public function toSmsUkraine($notifiable)
    {
        return SmsUkraineMessage::create()
            ->content('Some SMS notification message');
    }
}

```

В своей нотифицируемой моделе обязательно добавьте метод `routeNotificationForSmsUkraine()`, который возвращает номер телефона или массив телефонных номеров.

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use Notifiable;

    /**
     * Route notifications for the SmsUkraine channel.
     *
     * @param $notifiable
     * @return string
     */
    public function routeNotificationForSmsUkraine($notifiable)
    {
        return $this->phone;
    }
}

```


**Пример c использованием Notifiable Trait:**

```php
$user->notify(new InvoicePaid());
```


**Пример c использованием Notification Facade:**

```php
Notification::send($users, new InvoicePaid());
```



**Пример отправки SMS с использованием  фасадов(без использования Notification):**

```php
<?php

use Kagatan\SmsUkraine\Facades\SmsUkraine;
use Kagatan\SmsUkraine\SmsUkraineMessage;

public function test(){

        $message = SmsUkraineMessage::create()
            ->content("Example sending SMS.")
            ->to("380987654210")
            ->from("WiFi-POINT")
            ->toArray();

        $id = SmsUkraine::send($message);
        
        echo $id;
}
```

## Лицензирование

Код данного пакета распространяется под лицензией [MIT][link_license].


[getcomposer]:https://getcomposer.org/download/
[smsukraine_home]:https://smsukraine.com.ua/
[link_license]:https://github.com/kagatan/sms-ukraine/blob/master/LICENSE
