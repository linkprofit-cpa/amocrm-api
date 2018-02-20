<?php

use PHPUnit\Framework\TestCase;
use linkprofit\AmoCRM\entities\Field;

class FieldEntityTest extends TestCase
{
    public function testGet()
    {
        $field = $this->fieldProvider();
        $this->assertEquals(['origin' => 'origin_field', 'is_editable' => true, 'name' => 'Новое поле', 'element_type' => 1, 'field_type' => 1], $field->get());
    }

    public function testGetEnum()
    {
        $field = $this->fieldProvider();
        $field->field_type = Field::SELECT;
        $field->linkEnumArray(['1', '2', '3']);
        $this->assertEquals(['origin' => 'origin_field', 'is_editable' => true, 'name' => 'Новое поле', 'element_type' => 1, 'field_type' => 4, 'enums' => '1,2,3'], $field->get());
    }

    protected function fieldProvider()
    {
        $field = new Field();
        $field->origin = 'origin_field';
        $field->is_editable = true;
        $field->name = 'Новое поле';
        $field->element_type = Field::CONTACT_ELEMENT_TYPE;
        $field->field_type = Field::TEXT;

        return $field;
    }
}