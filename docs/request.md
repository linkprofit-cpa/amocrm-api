# Подключение

## Создание
Для выполнения запросов API из сервисов `linkprofit\AmoCRM\services` необходимо создать объект класса `RequestHandler` и задать ему subdomain. 

```php
$request = new \linkprofit\AmoCRM\RequestHandler();
$request->setSubdomain('domain');
```

## Использование

Используйте при инициализации сервиса
```php
$service = new \linkprofit\AmoCRM\services\ContactService($request);
```