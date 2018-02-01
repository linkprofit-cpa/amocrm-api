<?php

namespace linkprofit\AmoCRM;

class Connection
{
    public $login;
    public $apiHash;
    public $subdomain;

    public function __construct($login, $apiHash, $subdomain)
    {
        $this->login = $login;
        $this->apiHash = $apiHash;
        $this->subdomain = $subdomain;
    }
}