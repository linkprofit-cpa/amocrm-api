<?php

namespace linkprofit\AmoCRM\entities;

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
        return ['value' => $this->value, 'enum' => $this->enum];
    }
}