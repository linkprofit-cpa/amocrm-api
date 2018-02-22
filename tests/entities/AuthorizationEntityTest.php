<?php

namespace linkprofit\AmoCRM\tests\entities;

use PHPUnit\Framework\TestCase;

class AuthorizationEntityTest extends TestCase
{
    public function testGet()
    {
        $authorization = new \linkprofit\AmoCRM\entities\Authorization('login', 'api_key');
        $this->assertEquals(['USER_LOGIN' => 'login', 'USER_HASH' => 'api_key'], $authorization->get());
    }
}