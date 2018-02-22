# Сделки

## Настройка
Создайте сущность `linkprofit\AmoCRM\entities\Customer` и задайте ей необходимые параметры

```php
$customer = new \linkprofit\AmoCRM\entities\Customer();
$customer->created_by = 1924000;
$customer->responsible_user_id = 1924000;
$customer->name = 'Новый покупатель';
```
Задайте `id` сущности, если хотите обновить уже существующую.

## Использование
Инициализируйте сервис с объектом [linkprofit\AmoCRM\RequestHandler](/docs/request.md) и добавьте объект класса `linkprofit\AmoCRM\entities\Customer` методом `add()`.
Вы можете добавить несколько сущностей для множественного добавления/обновления

```php
$customerService = new \linkprofit\AmoCRM\services\CustomerService($request);
$customerService->add($customer);
```

Метод `save()` вернет `response` сервера в случае успеха. В случае неудачи метод вернет `false`.

Если вам необходимо обработать ответ, вы можете воспользоваться методом `parseResponseToEntities()`, который вернет массив добавленных объектов `linkprofit\AmoCRM\entities\Customer` с инициализированным свойством `id`, который вернулся ответом сервера на наш запрос.
