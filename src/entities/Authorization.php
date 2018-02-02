<?php

namespace linkprofit\AmoCRM\entities;

class Authorization implements EntityInterface
{
    public $login;
    public $apiHash;

    public function __construct($login, $apiHash)
    {
        $this->login = $login;
        $this->apiHash = $apiHash;
    }
}