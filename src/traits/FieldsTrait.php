<?php

namespace linkprofit\AmoCRM\traits;

/**
 * Class FieldsTrait
 * @package linkprofit\AmoCRM\traits
 */
trait FieldsTrait
{
    /**
     * @param $fieldList
     * @return array
     */
    public function getExistedValues($fieldList)
    {
        $fields = [];
        foreach ($fieldList as $field) {
            $fields[$field] = isset($this->$field) ? $this->$field : null;
        }

        $fields = array_filter($fields, 'strlen');

        return $fields;
    }
}