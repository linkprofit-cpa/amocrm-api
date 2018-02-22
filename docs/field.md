# Создание новый кастомных полей

## Настройка
Создайте сущность `linkprofit\AmoCRM\entities\Field` и задайте ей необходимые параметры

```php
$field = new Field();
$field->origin = 'origin_field';
$field->is_editable = true;
$field->name = 'Новое поле';
$field->element_type = Field::CONTACT_ELEMENT_TYPE;
$field->field_type = Field::TEXT;
```
Задайте `id` сущности, если хотите обновить уже существующую.

Для полей с использованием предустановленных значений, есть методы `linkEnum()` и `linkEnumArray()`. 

## Использование
Инициализируйте сервис с объектом [linkprofit\AmoCRM\RequestHandler](/docs/request.md) и добавьте объект класса `linkprofit\AmoCRM\entities\Field` методом `add()`.
Вы можете добавить несколько сущностей для множественного добавления/обновления

```php
$fieldService = new \linkprofit\AmoCRM\services\FieldService($request);
$fieldService->add($field);
```

Метод `save()` вернет `response` сервера в случае успеха. В случае неудачи метод вернет `false`.

Если вам необходимо обработать ответ, вы можете воспользоваться методом `parseResponseToEntities()`, который вернет массив добавленных объектов `linkprofit\AmoCRM\entities\Field` с инициализированным свойством `id`, который вернулся ответом сервера на наш запрос.
