# Аккаунт

## Использование
Инициализируйте сервис с объектом [linkprofit\AmoCRM\RequestHandler](/docs/request.md) и вызовите необходимый метод

```php
$accountService = new \linkprofit\AmoCRM\services\AccountService($request);
$accountService->getAccount(); // Вернет объект \linkprofit\AmoCRM\entities\Account
$accountService->getTaskTypes(); // Вернет массив объектов  \linkprofit\AmoCRM\entities\TaskType
```

На данный момент реализовано только получение основной информации по аккаунту и списка типов задач, но вы можете получить все данные в виде массива используя метод сервиса AccountService  `getAllArray()`

