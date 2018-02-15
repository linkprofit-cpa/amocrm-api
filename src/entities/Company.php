<?php

namespace linkprofit\AmoCRM\entities;

use linkprofit\AmoCRM\traits\ContactsLinkable;
use linkprofit\AmoCRM\traits\LeadsLinkable;

/**
 * Class Company
 * @package linkprofit\AmoCRM\entities
 */
class Company extends CustomizableEntity
{
    /**
     * @var string Название компании
     */
    public $name;

    /**
     * @var integer id пользователя создавшего компанию
     */
    public $created_by;

    /**
     * @var string Теги, привязываемые к компании. Задаются целостной строковой переменной, внутри строки перечисляются через запятую
     */
    public $tags;

    /**
     * @var string Покупатели, привязываемые к компании. Перечисляются через запятую.
     */
    public $customers_id;

    /**
     * @var array
     */
    protected $fieldList = [
        'id', 'name', 'created_at', 'updated_at',
        'responsible_user_id', 'created_by', 'tags',
        'leads_id', 'customers_id', 'contacts_id',
    ];

    use ContactsLinkable,
        LeadsLinkable {
        ContactsLinkable::mergeStringToField insteadof LeadsLinkable;
    }
}