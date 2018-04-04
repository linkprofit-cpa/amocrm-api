# Контакты

## Настройка
Создайте сущность `linkprofit\AmoCRM\entities\Company` и задайте ей необходимые параметры

```php
$company = new \linkprofit\AmoCRM\entities\Company();
$company->responsible_user_id = 1924000;
$company->name = 'Рога и копыта';
```
Задайте `id` сущности, если хотите обновить уже существующую.

## Использование
Инициализируйте сервис с объектом [linkprofit\AmoCRM\RequestHandler](/docs/request.md) и добавьте объект класса `linkprofit\AmoCRM\entities\Company` методом `add()`.
Вы можете добавить несколько сущностей для множественного добавления/обновления

```php
$companyService = new \linkprofit\AmoCRM\services\CompanyService($request);
$companyService->add($company);
```

Метод `save()` вернет `response` сервера в случае успеха. В случае неудачи метод вернет `false`.

Если вам необходимо обработать ответ, вы можете воспользоваться методом `parseResponseToEntities()`, который вернет массив добавленных объектов `linkprofit\AmoCRM\entities\Company` с инициализированным свойством `id`, который вернулся ответом сервера на наш запрос.
