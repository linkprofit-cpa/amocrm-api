<?php

namespace linkprofit\AmoCRM\tests\entities;

use PHPUnit\Framework\TestCase;
use linkprofit\AmoCRM\entities\Field;
use linkprofit\AmoCRM\tests\providers\FieldProvider;

class FieldEntityTest extends TestCase
{
    /**
     * @var FieldProvider
     */
    protected $field;

    public function testGet()
    {
        $field = $this->field->getField();
        $this->assertEquals(['origin' => 'origin_field', 'is_editable' => true, 'name' => 'Новое поле', 'element_type' => 1, 'field_type' => 1], $field->get());
    }

    public function testGetEnum()
    {
        $field = $this->field->getField();
        $field->field_type = Field::SELECT;
        $field->linkEnumArray(['1', '2', '3']);
        $this->assertEquals(['origin' => 'origin_field', 'is_editable' => true, 'name' => 'Новое поле', 'element_type' => 1, 'field_type' => 4, 'enums' => ['1','2','3']], $field->get());
    }

    protected function setUp()
    {
        $this->field = new FieldProvider();
    }
}