<?php

namespace linkprofit\AmoCRM\tests\entities;

use PHPUnit\Framework\TestCase;
use linkprofit\AmoCRM\tests\providers\CustomFieldProvider;

class CustomFieldEntityTest extends TestCase
{
    /**
     * @var CustomFieldProvider
     */
    protected $customField;

    public function testGet()
    {
        $customField = new \linkprofit\AmoCRM\entities\CustomField('146785', 'email', 'EMAIL');
        $this->assertEquals(['id' => '146785', 'name' => 'email', 'code' => 'EMAIL'], $customField->get());
    }

    public function testValueAdd()
    {
        $customField = $this->customField->getEmailField();
        $this->assertEquals(['id' => '146785', 'name' => 'email', 'code' => 'EMAIL', 'values' => [['value' => 'email@email.com', 'enum' => '304683']]], $customField->get());
    }

    public function testValuesAdd()
    {
        $customField = $this->customField->getEmailField();
        $customField->addValue(new \linkprofit\AmoCRM\entities\Value(
                'email2@email.com', '304683'
            )
        );
        $this->assertEquals(['id' => '146785', 'name' => 'email', 'code' => 'EMAIL', 'values' => [['value' => 'email@email.com', 'enum' => '304683'], ['value' => 'email2@email.com', 'enum' => '304683']]], $customField->get());
    }

    protected function setUp()
    {
        $this->customField = new CustomFieldProvider();
    }
}