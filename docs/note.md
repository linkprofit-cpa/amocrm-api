# Заметки

## Настройка
Создайте сущность `linkprofit\AmoCRM\entities\Note` и задайте ей необходимые параметры

```php
$note = new \linkprofit\AmoCRM\entities\Note();
$note->text = 'Заметка';
$note->note_type = $note::COMMON;
$note->responsible_user_id = 1924000;
```

Задайте `id` сущности, если хотите обновить уже существующую.

Вы можете прикрепить к сущности `linkprofit\AmoCRM\entities\Note` объекты классов `linkprofit\AmoCRM\entities\Contact` и `linkprofit\AmoCRM\entities\Lead` и `linkprofit\AmoCRM\entities\Task` с заданным свойством `id`

```php
$contact = new \linkprofit\AmoCRM\entities\Contact();
$contact->id = 42;
$note->linkElement($contact);
```

## Использование
Инициализируйте сервис с объектом [linkprofit\AmoCRM\RequestHandler](/docs/request.md) и добавьте объект класса `linkprofit\AmoCRM\entities\Note` методом `add()`.
Вы можете добавить несколько сущностей для множественного добавления/обновления

```php
$noteService = new \linkprofit\AmoCRM\services\NoteService($request);
$noteService->add($note);
```

Метод `save()` вернет `response` сервера в случае успеха. В случае неудачи метод вернет `false`.

Если вам необходимо обработать ответ, вы можете воспользоваться методом `parseResponseToEntities()`, который вернет массив добавленных объектов `linkprofit\AmoCRM\entities\Note` с инициализированным свойством `id`, который вернулся ответом сервера на наш запрос.
