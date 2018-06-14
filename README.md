## Installation

**Install via composer**

Require this package with composer using the following command:

```
composer require kagatan/sms-ukraine
```

**Add service provider ( Laravel 5.4 or below )**

After updating composer, add the service provider to the providers array in config/app.php 

```
'providers' => [
    ...
    Kagatan\SmsUkraine\SmsUkraineServiceProvider::class,
]
```

**Add facade**

```
 'aliases' => [
    ...
    'SmsUkraine' => Kagatan\SmsUkraine\Facades\SmsUkraine::class
]
```


**Publish the config**

Run the following command to publish the package config file:

```
php artisan vendor:publish --provider="Kagatan\SmsUkraine\SmsUkraineServiceProvider"
```
You should now have a config/smsukraine.php file that allows you to configure the basics of this package.
 
 
## Upgrading
 
```
composer update kagatan/sms-ukraine
```
 
## Configuration
Добавьте ваш .env файл ключ SMSUKRAINE_KEY, где вместо xxxx ведите API key.

```
SMSUKRAINE_KEY= xxxxxxxxxxxxxxxxxxxxxx

```
Если хотите использовать связку логин/пароль то добавляем след ключи:

```
SMSUKRAINE_LOGIN= xxxxx

SMSUKRAINE_PASSWORD= xxxxx

```
 

## Usage

**Пример использования:**

```

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

**Доступные методы:**

