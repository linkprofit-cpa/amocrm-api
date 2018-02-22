<?php

namespace linkprofit\AmoCRM\tests\entities;

use PHPUnit\Framework\TestCase;

class ValueEntityTest extends TestCase
{
    public function testGet()
    {
        $value = new \linkprofit\AmoCRM\entities\Value('email@email.com', '304683');
        $this->assertEquals(['value' => 'email@email.com', 'enum' => '304683'], $value->get());
    }

    public function testFullGet()
    {
        $value = new \linkprofit\AmoCRM\entities\Value('email@email.com', '304683');
        $value->is_system = 0;
        $value->subtype = 'subtype';
        $this->assertEquals(['value' => 'email@email.com', 'enum' => '304683', 'is_system' => 0, 'subtype' => 'subtype'], $value->get());
    }
}