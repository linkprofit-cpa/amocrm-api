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

### Получение списка существующих элементов
Просто вызовите метод `getList()` у сервиса, в ответ придет массив объектов класса `linkprofit\AmoCRM\entities\Company`. Ограничения на один запрос 500 элементов, если нужно вывести более 500 элементов используйте несколько запросов передавая в метод номер страницы в метод `setPage(2)`
```php
$companies = $service->getList(); //Вернет массив всех элементов (не более 500)
$companies = $service->setPage(3)->getList(); //Вернет массив всех элементов с 3 страницы
$companies = $service->setPage(3)->setTerm('Поисковая строка')->getList(); //Вернет массив всех элементов 3 страницы, по поисковой строке 'Поисковая строка'
```

Отельно элемент можно получить по его id, в ответ придет массив с единственным элементом `linkprofit\AmoCRM\entities\Company`
```php
$elementId = 1232;
$company = $service->setId($elementId)->getList();