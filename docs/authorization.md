# Авторизация

## Настройка
Создайте сущность `linkprofit\AmoCRM\entities\Authorization` и задайте ей параметры авторизации

```php
$connection = new \linkprofit\AmoCRM\entities\Authorization(
    'domain@mail.com',
    'api_key'
);
```


## Использование
Инициализируйте сервис с объектом [linkprofit\AmoCRM\RequestHandler](/docs/request.md) и добавьте объект класса `linkprofit\AmoCRM\entities\Authorization` методом `add()`

```php
$authorization = new \linkprofit\AmoCRM\services\AuthorizationService($request);
$authorization->add($connection);
$authorization->authorize();
```

Метод `authorize()` вернет `true` в случае успеха и создаст файл `cookie.txt` в корневом каталоге. В случае неудачи метод вернет `false`