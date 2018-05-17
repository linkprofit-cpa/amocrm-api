# Задачи

## Настройка
Создайте сущность `linkprofit\AmoCRM\entities\Catalog` и задайте ей необходимые параметры

```php
$catalog = new \linkprofit\AmoCRM\entities\Catalog();
$catalog->name = 'Товары';
$catalog->type = $catalog::CATALOG_TYPE_REGULAR;
$catalog->can_add_elements = true;
$catalog->can_show_in_cards = true;
$catalog->can_link_multiple = true;
```

Задайте `id` сущности, если хотите обновить уже существующую.

## Использование

### Добавление каталогов
Инициализируйте сервис с объектом [linkprofit\AmoCRM\RequestHandler](/docs/request.md) и добавьте объект класса `linkprofit\AmoCRM\entities\Catalog` методом `add()`.
Вы можете добавить несколько сущностей для множественного добавления/обновления

```php
$catalogService = new \linkprofit\AmoCRM\services\CatalogService($request);
$catalogService->add($catalog);
```

Метод `save()` вернет `response` сервера в случае успеха. В случае неудачи метод вернет `false`.

Если вам необходимо обработать ответ, вы можете воспользоваться методом `parseResponseToEntities()`, который вернет массив добавленных объектов `linkprofit\AmoCRM\entities\Task` с инициализированным свойством `id`, который вернулся ответом сервера на наш запрос.

### Получение списка существующих каталогов
Просто вызовите метод `getList()` у сервиса, в ответ придет массив объектов класса `linkprofit\AmoCRM\entities\Catalog`
```php
$catalogService = new \linkprofit\AmoCRM\services\CatalogService($request);
$catalogs = $catalogService->getList();
```

Также можно получить только интересующий каталог по его id, в ответ придет массив с одним объектом класса `linkprofit\AmoCRM\entities\Catalog`
```php
$id = 1823;
$catalogs = $catalogService->setId($id)->getList();
```
