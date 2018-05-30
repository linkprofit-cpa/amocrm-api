# Элементы каталога

## Настройка
Создайте сущность `linkprofit\AmoCRM\entities\CatalogElement` и задайте ей необходимые параметры

```php
$catalog = new \linkprofit\AmoCRM\entities\CatalogElement();
$catalog->name = 'Элемент каталога'; // Название элемента
$element->catalog_id = 1234; // Id каталога, в который хотим добавить или обновить сущность
```

Задайте `id` сущности, если хотите обновить уже существующую.

## Использование

### Добавление элементов каталога
Инициализируйте сервис с объектом [linkprofit\AmoCRM\RequestHandler](/docs/request.md) и добавьте объект класса `linkprofit\AmoCRM\entities\CatalogElement` методом `add()`.
Вы можете добавить несколько сущностей для множественного добавления/обновления

```php
$catalogService = new \linkprofit\AmoCRM\services\CatalogElementService($request);
$catalogService->add($element);
```

Метод `save()` вернет `response` сервера в случае успеха. В случае неудачи метод вернет `false`.

Если вам необходимо обработать ответ, вы можете воспользоваться методом `parseResponseToEntities()`, который вернет массив добавленных объектов `linkprofit\AmoCRM\entities\CatalogElement` с инициализированным свойством `id`, который вернулся ответом сервера на наш запрос

### Получение списка существующих элементов каталога
Просто вызовите метод `getList()` у сервиса, в ответ придет массив объектов класса `linkprofit\AmoCRM\entities\CatalogElement`. Ограничения на один запрос 500 элементов, если нужно вывести более 500 элементов используйте несколько запросов передавая в метод номер страницы в метод `setPage(2)`
```php
$service = new \linkprofit\AmoCRM\services\CatalogElementService($request);
$catalogs = $service->getList(); //Вернет массив всех элементов (не более 500)
$catalogs = $service->setPage(3)->getList(); //Вернет массив всех элементов с 3 страницы
$catalogs = $service->setPage(3)->setQuery('Поисковая строка')->getList(); //Вернет массив всех элементов 3 страницы, по поисковой строке 'Поисковая строка'
```

Также можно получить только интересующие элементы каталога по его catalog_id, в ответ придет массив `linkprofit\AmoCRM\entities\CatalogElement` только с элементами из этого каталога
```php
$catalogId = 1823;
$catalogs = $service->setParams(['catalog_id' => $catalogId])->getList();
```
Отельно элемент можно получить по его id, в ответ придет массив с единственным элементом `linkprofit\AmoCRM\entities\CatalogElement`
```php
$elementId = 1232;
$catalogs = $service->setParams(['id' => $elementId])->getList();
```
