<?php

namespace linkprofit\AmoCRM\entities;

/**
 * Class Lead
 * @package linkprofit\AmoCRM\entities
 */
class Contact extends CustomizableEntity
{
    public $id;
    public $name;
    public $created_at;
    public $updated_at;
    public $responsible_user_id;
    public $created_by;
    public $company_name;
    public $tags;
    public $leads_id;
    public $customers_id;
    public $company_id;

    protected $fieldList = [
        'id', 'name', 'created_at', 'updated_at',
        'responsible_user_id', 'created_by', 'company_name',
        'tags', 'leads_id', 'customers_id', 'company_id',
    ];

    /**
     * @param $array
     */
    public function set($array)
    {
        $this->setFromArray($this->fieldList, $array);
    }
}