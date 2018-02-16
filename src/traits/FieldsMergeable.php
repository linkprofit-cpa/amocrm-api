<?php

namespace linkprofit\AmoCRM\traits;

/**
 * Class FieldsMergeable
 * @package linkprofit\AmoCRM\traits
 */
trait FieldsMergeable
{
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