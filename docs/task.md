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
