<?php

namespace linkprofit\AmoCRM\traits;

/**
 * Class FieldList
 * @package linkprofit\AmoCRM\traits
 */
trait FieldList
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

        $fields = array_filter($fields, function($field) {
            if (is_array($field)) {
                return !empty($field);
            }

            return strlen($field);
        });

        return $fields;
    }

    /**
     * @param $fieldList
     * @param $array
     */
    public function setFromArray($fieldList, $array)
    {
        foreach ($fieldList as $field) {
            $this->$field = isset($array[$field]) ? $array[$field] : null;
        }
    }
}
