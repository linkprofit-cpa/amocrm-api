<?php

namespace linkprofit\AmoCRM\entities;

/**
 * Class Lead
 * @package linkprofit\AmoCRM\entities
 */
class Lead extends CustomizableEntity
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
    public $price;

    protected $fieldList = [
        'id', 'name', 'created_at', 'updated_at',
        'status_id', 'pipeline_id', 'responsible_user_id',
        'sale', 'tags', 'contacts_id', 'company_id', 'price'
    ];

    /**
     * @param $array
     */
    public function set($array)
    {
        $this->setFromArray($this->fieldList, $array);
    }
}