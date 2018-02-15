<?php

namespace linkprofit\AmoCRM\entities;

use linkprofit\AmoCRM\traits\FieldList;

/**
 * Class CustomizableEntity
 * @package linkprofit\AmoCRM\entities
 */
abstract class CustomizableEntity implements EntityInterface
{
    /**
     * @var array
     */
    protected $fieldList = [];

    /**
     * @var array
     */
    protected $custom_fields = [];

    use FieldList;

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