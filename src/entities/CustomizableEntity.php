<?php

namespace linkprofit\AmoCRM\entities;

use linkprofit\AmoCRM\traits\FieldsTrait;

/**
 * Class CustomizableEntity
 * @package linkprofit\AmoCRM\entities
 */
abstract class CustomizableEntity implements EntityInterface
{
    protected $fieldList;
    protected $custom_fields = [];

    use FieldsTrait;

    /**
     * @param CustomField $field
     */
    public function addCustomField(CustomField $field)
    {
        $this->custom_fields[] = $field;
    }

    /**
     * @return array
     */
    public function get()
    {
        $custom_fields = [];
        foreach ($this->custom_fields as $custom_field) {
            $custom_fields[] = $custom_field->get();
        }

        $fields = $this->getExistedValues($this->fieldList);

        if (count($custom_fields)) {
            $fields['custom_fields'] = $custom_fields;
        }

        return $fields;
    }
}