<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 15.02.18
 * Time: 16:11
 */

namespace linkprofit\AmoCRM\traits;

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