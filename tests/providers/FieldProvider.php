<?php

namespace linkprofit\AmoCRM\tests\providers;
use linkprofit\AmoCRM\entities\Field;

class FieldProvider
{
    public function getField()
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