<?php

namespace linkprofit\AmoCRM\entities;

use linkprofit\AmoCRM\traits\CompanyLinkable;
use linkprofit\AmoCRM\traits\LeadsLinkable;

/**
 * Class Contact
 * @package linkprofit\AmoCRM\entities
 */
class Contact extends CustomizableEntity
{
    /**
     * @var string Название контакта
     */
    public $name;

    /**
     * @var integer id пользователя создавшего контакт
     */
    public $created_by;

    /**
     * @var string Название новой компании. Параметр указывается для создания новой компании и привязке к ней контакта. Для привязки контакта к уже существующей компании, необходимо использовать параметр company_id
     */
    public $company_name;

    /**
     * @var string Теги, привязываемые к контакту. Задаются целостной строковой переменной, внутри строки перечисляются через запятую
     */
    public $tags;

    /**
     * @var string Покупатели, привязываемые к контакту. Перечисляются через запятую.
     */
    public $customers_id;

    use CompanyLinkable,
        LeadsLinkable;

    /**
     * @var array
     */
    protected $fieldList = [
        'id', 'name', 'created_at', 'updated_at',
        'responsible_user_id', 'created_by', 'company_name',
        'tags', 'leads_id', 'customers_id', 'company_id',
    ];
}