# Контакты

## Настройка
Создайте сущность `linkprofit\AmoCRM\entities\Contact` и задайте ей необходимые параметры

```php
$contact = new \linkprofit\AmoCRM\entities\Contact();
$contact->responsible_user_id = 1924000;
$contact->name = 'Василий Аркадьевич';
```
Задайте `id` сущности, если хотите обновить уже существующую.

## Использование
Инициализируйте сервис с объектом [linkprofit\AmoCRM\RequestHandler](/docs/request.md) и добавьте объект класса `linkprofit\AmoCRM\entities\Contact` методом `add()`.
Вы можете добавить несколько сущностей для множественного добавления/обновления

```php
$contactService = new \linkprofit\AmoCRM\services\ContactService($request);
$contactService->add($contact);
```

Метод `save()` вернет `response` сервера в случае успеха. В случае неудачи метод вернет `false`.

Если вам необходимо обработать ответ, вы можете воспользоваться методом `parseResponseToEntities()`, который вернет массив добавленных объектов `linkprofit\AmoCRM\entities\Contact` с инициализированным свойством `id`, который вернулся ответом сервера на наш запрос.

### Получение списка существующих элементов
Просто вызовите метод `getList()` у сервиса, в ответ придет массив объектов класса `linkprofit\AmoCRM\entities\Contact`. Ограничения на один запрос 500 элементов, если нужно вывести более 500 элементов используйте несколько запросов передавая в метод номер страницы в метод `setPage(2)`
```php
$contacts = $service->getList(); //Вернет массив всех элементов (не более 500)
$contacts = $service->setPage(3)->getList(); //Вернет массив всех элементов с 3 страницы
$contacts = $service->setPage(3)->setTerm('Поисковая строка')->getList(); //Вернет массив всех элементов 3 страницы, по поисковой строке 'Поисковая строка'
```

Отельно элемент можно получить по его id, в ответ придет массив с единственным элементом `linkprofit\AmoCRM\entities\Contact`
```php
$elementId = 1232;
$contact = $service->setId($elementId)->getList();