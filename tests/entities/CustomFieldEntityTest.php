<?php

use PHPUnit\Framework\TestCase;

class CustomFieldEntityTest extends TestCase
{
    public function testGet()
    {
        $customField = new \linkprofit\AmoCRM\entities\CustomField('146785', 'email', 'EMAIL');
        $this->assertEquals(['id' => '146785', 'name' => 'email', 'code' => 'EMAIL', 'values' => []], $customField->get());
    }

    public function testValueAdd()
    {
        $customField = new \linkprofit\AmoCRM\entities\CustomField('146785', 'email', 'EMAIL');
        $customField->addValue(new \linkprofit\AmoCRM\entities\Value(
            'email@email.com', '304683'
            )
        );
        $this->assertEquals(['id' => '146785', 'name' => 'email', 'code' => 'EMAIL', 'values' => [['value' => 'email@email.com', 'enum' => '304683']]], $customField->get());
    }

    public function testValuesAdd()
    {
        $customField = new \linkprofit\AmoCRM\entities\CustomField('146785', 'email', 'EMAIL');
        $customField->addValue(new \linkprofit\AmoCRM\entities\Value(
                'email@email.com', '304683'
            )
        );
        $customField->addValue(new \linkprofit\AmoCRM\entities\Value(
                'email2@email.com', '304683'
            )
        );
        $this->assertEquals(['id' => '146785', 'name' => 'email', 'code' => 'EMAIL', 'values' => [['value' => 'email@email.com', 'enum' => '304683'], ['value' => 'email2@email.com', 'enum' => '304683']]], $customField->get());
    }
}