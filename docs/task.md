# Задачи

## Настройка
Создайте сущность `linkprofit\AmoCRM\entities\Task` и задайте ей необходимые параметры

```php
$task = new \linkprofit\AmoCRM\entities\Task();
$task->text = 'Задача';

$nextDayTimestamp = strtotime('+1 day');
$task->complete_till_at = $nextDayTimestamp;

$task->task_type = $task::CALL_TASK_TYPE;
$task->responsible_user_id = 1924000;
```

Задайте `id` сущности, если хотите обновить уже существующую.

Вы можете прикрепить к сущности `linkprofit\AmoCRM\entities\Task` объекты классов `linkprofit\AmoCRM\entities\Contact` и `linkprofit\AmoCRM\entities\Lead` с заданным свойством `id`

```php
$contact = new \linkprofit\AmoCRM\entities\Contact();
$contact->id = 42;
$task->linkElement($contact);
```

## Использование
Инициализируйте сервис с объектом [linkprofit\AmoCRM\RequestHandler](/docs/request.md) и добавьте объект класса `linkprofit\AmoCRM\entities\Task` методом `add()`.
Вы можете добавить несколько сущностей для множественного добавления/обновления

```php
$taskService = new \linkprofit\AmoCRM\services\TaskService($request);
$taskService->add($task);
```

Метод `save()` вернет `response` сервера в случае успеха. В случае неудачи метод вернет `false`.

Если вам необходимо обработать ответ, вы можете воспользоваться методом `parseResponseToEntities()`, который вернет массив добавленных объектов `linkprofit\AmoCRM\entities\Task` с инициализированным свойством `id`, который вернулся ответом сервера на наш запрос.

### Получение списка существующих элементов
Просто вызовите метод `getList()` у сервиса, в ответ придет массив объектов класса `linkprofit\AmoCRM\entities\Task`. Ограничения на один запрос 500 элементов, если нужно вывести более 500 элементов используйте несколько запросов передавая в метод номер страницы в метод `setPage(2)`
```php
$tasks = $service->getList(); //Вернет массив всех элементов (не более 500)
$tasks = $service->setPage(3)->getList(); //Вернет массив всех элементов с 3 страницы
```

Отельно элемент можно получить по его id, в ответ придет массив с единственным элементом `linkprofit\AmoCRM\entities\Task`
```php
$elementId = 1232;
$task = $service->setId($elementId)->getList();