<?php

namespace linkprofit\AmoCRM\entities;

/**
 * Class CustomField
 * @package linkprofit\AmoCRM
 */
class CustomField implements EntityInterface
{
    public $id;
    public $name;
    public $code;

    /**
     * @var array Value
     */
    protected $values = [];

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
        if (!($this->id && $this->name && $this->code)) {
            return [];
        }

        $field = ['id' => $this->id, 'name' => $this->name, 'code' => $this->code, 'values' => []];

        foreach ($this->values as $value) {
            $field['values'][] = $value->get();
        }

        return $field;
    }
}