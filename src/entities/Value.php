<?php

namespace linkprofit\AmoCRM\entities;

use linkprofit\AmoCRM\traits\FieldList;

/**
 * Class Value
 * @package linkprofit\AmoCRM\entities
 */
class Value implements EntityInterface
{
    /**
     * @var string Значение дополнительного поля
     */
    public $value;

    /**
     * @var string Идентификатор раннее предустановленного варианта выбора для списка или мультисписка
     */
    public $enum;

    /**
     * @var string Тип изменяемого элемента дополнительного поля
     */
    public $subtype;

    /**
     * @var boolean
     */
    public $is_system;

    /**
     * @var array
     */
    protected $fieldList = [
        'value', 'enum', 'subtype', 'is_system'
    ];

    use FieldList;

    /**
     * Value constructor.
     * @param $value
     * @param $enum
     */
    public function __construct($value, $enum = null)
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