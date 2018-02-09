# Контакты

## Настройка
Создайте сущность `linkprofit\AmoCRM\entities\Contact` и задайте ей необходимые параметры

```php
$contact = new \linkprofit\AmoCRM\entities\Contact();
$contact->responsible_user_id = 1924000;
$contact->name = 'Василий Аркадьевич';
```

## Использование
Инициализируйте сервис с объектом [linkprofit\AmoCRM\RequestHandler](/docs/request.md) и добавьте объект класса `linkprofit\AmoCRM\entities\Contact` методом `add()`.
Вы можете добавить несколько сущностей для множественного добавления

```php
$contactService = new \linkprofit\AmoCRM\services\ContactService($request);
$contactService->add($contact);
```

Метод `create()` вернет `response` сервера в случае успеха. В случае неудачи метод вернет `false`.

Если вам необходимо обработать ответ, вы можете воспользоваться методом `parseResponseToEntities()`, который вернет массив добавленных объектов `linkprofit\AmoCRM\entities\Contact` с инициализированным свойством `id`, который вернулся ответом сервера на наш запрос.
