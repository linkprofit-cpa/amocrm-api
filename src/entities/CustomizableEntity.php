<?php

namespace linkprofit\AmoCRM\entities;

/**
 * Class CustomizableEntity
 * @package linkprofit\AmoCRM\entities
 */
abstract class CustomizableEntity extends BaseEntity
{
    /**
     * @var CustomField[]
     */
    protected $custom_fields = [];

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
        if ($this->id) {
            $this->setUpdatedTime();
        }

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