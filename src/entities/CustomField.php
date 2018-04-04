<?php

namespace linkprofit\AmoCRM\entities;

use linkprofit\AmoCRM\traits\FieldList;

/**
 * Class CustomField
 * @package linkprofit\AmoCRM\entities
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
     * @var Value[]
     */
    protected $values = [];

    /**
     * @var array
     */
    protected $fieldList = [
        'id', 'name', 'code'
    ];

    use FieldList;

    /**
     * CustomField constructor.
     * @param $id
     * @param null $name
     * @param null $code
     */
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