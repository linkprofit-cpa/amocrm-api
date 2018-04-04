# Сделки

## Настройка
Создайте сущность `linkprofit\AmoCRM\entities\Lead` и задайте ей необходимые параметры

```php
$lead = new \linkprofit\AmoCRM\entities\Lead();
$lead->status_id = 17077744;
$lead->sale = 0;
$lead->responsible_user_id = 1924000;
```
Задайте `id` сущности, если хотите обновить уже существующую.

## Использование
Инициализируйте сервис с объектом [linkprofit\AmoCRM\RequestHandler](/docs/request.md) и добавьте объект класса `linkprofit\AmoCRM\entities\Lead` методом `add()`.
Вы можете добавить несколько сущностей для множественного добавления/обновления

```php
$leadService = new \linkprofit\AmoCRM\services\LeadService($request);
$leadService->add($lead);
```

Метод `save()` вернет `response` сервера в случае успеха. В случае неудачи метод вернет `false`.

Если вам необходимо обработать ответ, вы можете воспользоваться методом `parseResponseToEntities()`, который вернет массив добавленных объектов `linkprofit\AmoCRM\entities\Lead` с инициализированным свойством `id`, который вернулся ответом сервера на наш запрос.
