<?php

namespace linkprofit\AmoCRM\entities;

use linkprofit\AmoCRM\traits\FieldsTrait;

/**
 * Class Lead
 * @package linkprofit\AmoCRM\entities
 */
class Lead implements EntityInterface
{
    public $id;
    public $name;
    public $created_at;
    public $updated_at;
    public $status_id;
    public $pipeline_id;
    public $responsible_user_id;
    public $sale;
    public $tags;
    public $contacts_id;
    public $company_id;
    public $custom_fields = [];
    public $price;

    protected $fieldList = [
        'id', 'name', 'created_at', 'updated_at',
        'status_id', 'pipeline_id', 'responsible_user_id',
        'sale', 'tags', 'contacts_id', 'company_id', 'price'
    ];

    use FieldsTrait;

    /**
     * @param CustomField $field
     */
    public function addCustomField(CustomField $field)
    {
        $this->custom_fields[] = $field;
    }

    /**
     * @return array
     */
    public function get()
    {
        $custom_fields = [];
        foreach ($this->custom_fields as $custom_field) {
            $custom_fields[] = $custom_field->get();
        }

        $fields = $this->getExistedValues($this->fieldList);

        if (count($custom_fields)) {
            $fields['custom_fields'] = $custom_fields;
        }

        return $fields;
    }
}