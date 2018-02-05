<?php

namespace linkprofit\AmoCRM\entities;

/**
 * Class Lead
 * @package linkprofit\AmoCRM\entities
 */
class Lead implements EntityInterface
{
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
        'name', 'created_at', 'updated_at',
        'status_id', 'pipeline_id', 'responsible_user_id',
        'sale', 'tags', 'contacts_id', 'company_id', 'price'
    ];

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

        $fields = [];
        foreach ($this->fieldList as $field) {
            $fields[$field] = $this->$field ? $this->$field : null;
        }

        $fields = array_filter($fields, 'strlen');

        $fields['custom_fields'] = $custom_fields;

        return $fields;
    }
}