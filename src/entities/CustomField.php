<?php

namespace linkprofit\AmoCRM\entities;

use linkprofit\AmoCRM\traits\FieldsTrait;

/**
 * Class CustomField
 * @package linkprofit\AmoCRM
 */
class CustomField implements EntityInterface
{
    public $id;
    public $name;
    public $code;

    use FieldsTrait;

    /**
     * @var array Value
     */
    protected $values = [];

    protected $fieldList = [
        'id', 'name', 'code'
    ];

    public function __construct($id, $name, $code)
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