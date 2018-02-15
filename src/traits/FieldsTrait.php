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

    /**
     * @param $fieldName
     * @param $string
     */
    public function mergeStringToField($string, $fieldName)
    {
        $string = (string) $string;
        $fieldIsSet = mb_strlen($this->$fieldName) > 0 && !is_array($this->$fieldName);

        if (!$fieldIsSet) {
            $this->$fieldName = $string;
        } else {
            $this->$fieldName .= ',' . $string;
        }
    }
}