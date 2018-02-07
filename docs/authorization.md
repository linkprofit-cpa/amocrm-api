# Авторизация

## Настройка параметров подключения

```php
$connection = new \linkprofit\AmoCRM\entities\Authorization(
    'domain@mail.com',
    'api_key'
);
```

## Создание подключения

```php
$request = new \linkprofit\AmoCRM\RequestHandler();
$request->setSubdomain('domain');
```

## Авторизация

```php
$authorization = new \linkprofit\AmoCRM\services\AuthorizationService($request);
$authorization->add($connection);
$authorization->authorize();
```

Метод `authorize()` вернет `true` в случае успеха и создаст файл `cookie.txt` в корневом каталоге. В случае неудачи метод вернет `false`.