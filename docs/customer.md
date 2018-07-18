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

### Получение списка существующих элементов
Просто вызовите метод `getList()` у сервиса, в ответ придет массив объектов класса `linkprofit\AmoCRM\entities\Customer`. Ограничения на один запрос 500 элементов, если нужно вывести более 500 элементов используйте несколько запросов передавая в метод номер страницы в метод `setPage(2)`
```php
$customers = $service->getList(); //Вернет массив всех элементов (не более 500)
$customers = $service->setPage(3)->getList(); //Вернет массив всех элементов с 3 страницы
```

Отельно элемент можно получить по его id, в ответ придет массив с единственным элементом `linkprofit\AmoCRM\entities\Customer`
```php
$elementId = 1232;
$customer = $service->setId($elementId)->getList();