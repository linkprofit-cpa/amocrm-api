# Кастомные поля

## Создание
Рассмотрим кастомные поля на примере поля для электронной почты

Задаём `id`, который можно узнать через панель администратора в amoCRM
```php
$customField = new \linkprofit\AmoCRM\entities\CustomField($id = '146785');
```
Можем задать так же `code` и `name`
```php
$customField->name = 'email';
$customField->code = 'EMAIL';
```
создаем `Value` для `CustomField`
```php
$value = new \linkprofit\AmoCRM\entities\Value('email@email.com', '304683');
```
Добавляем `Value` в `CustomField`, их может быть несколько одновременно
```php
$customField->addValue($value);
```

## Использование

Созданный `$customField` можно добавлять в сущности, наследуемые от `linkprofit\AmoCRM\entitiesCustomizableEntity`.
Например, `linkprofit\AmoCRM\entities\Contact` и `linkprofit\AmoCRM\entities\Lead`.

Пример:

```php
$contact = new \linkprofit\AmoCRM\entities\Contact();
$contact->addCustomField($customField);
```