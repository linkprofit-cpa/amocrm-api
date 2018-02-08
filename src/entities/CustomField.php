<?php

namespace linkprofit\AmoCRM\entities;

use linkprofit\AmoCRM\traits\FieldsTrait;

/**
 * Class CustomField
 * @package linkprofit\AmoCRM
 */
class CustomField implements EntityInterface
{
    /**
     * @var integer Уникальный идентификатор заполняемого дополнительного поля
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $code;

    /**
     * @var array Value
     */
    protected $values = [];

    /**
     * @var array
     */
    protected $fieldList = [
        'id', 'name', 'code'
    ];

    use FieldsTrait;

    public function __construct($id, $name = null, $code = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
    }

    /**
     * @param Value $value
     */
    public function addValue(Value $value)
    {
        $this->values[] = $value;
    }

    /**
     * @return array
     */
    public function get()
    {
        $fields = $this->getExistedValues($this->fieldList);

        $values = [];
        foreach ($this->values as $value) {
            $values[] = $value->get();
        }

        if (count($values)) {
            $fields['values'] = $values;
        }

        return $fields;
    }
}