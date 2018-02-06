<?php

namespace linkprofit\AmoCRM\entities;

use linkprofit\AmoCRM\traits\FieldsTrait;

/**
 * Class Value
 * @package linkprofit\AmoCRM
 */
class Value implements EntityInterface
{
    public $value;
    public $enum;
    public $subtype;
    public $is_system;

    protected $fieldList = [
        'value', 'enum', 'subtype', 'is_system'
    ];

    use FieldsTrait;

    /**
     * Value constructor.
     * @param $value
     * @param $enum
     */
    public function __construct($value, $enum)
    {
        $this->value = $value;
        $this->enum = $enum;
    }

    /**
     * @return array
     */
    public function get()
    {
        return $this->getExistedValues($this->fieldList);
    }
}