<?php

namespace linkprofit\AmoCRM\entities;

/**
 * Class Authorization
 * @package linkprofit\AmoCRM\entities
 */
class Authorization implements EntityInterface
{
    /**
     * @var string Логин пользователя. В качестве логина в системе используется e-mail.
     */
    public $login;

    /**
     * @var string Ключ пользователя, который можно получить на странице редактирования профиля пользователя.
     */
    public $apiHash;

    /**
     * Authorization constructor.
     * @param $login
     * @param $apiHash
     */
    public function __construct($login, $apiHash)
    {
        $this->login = $login;
        $this->apiHash = $apiHash;
    }

    /**
     * @return array
     */
    public function get()
    {
        return [
            'USER_LOGIN' => $this->login,
            'USER_HASH' => $this->apiHash
        ];
    }
}