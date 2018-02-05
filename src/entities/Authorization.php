<?php

namespace linkprofit\AmoCRM\entities;

/**
 * Class Authorization
 * @package linkprofit\AmoCRM\entities
 */
class Authorization implements EntityInterface
{
    public $login;
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