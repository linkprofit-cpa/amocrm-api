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
     * @var integer id контакта, в которого будут вноситься изменения
     */
    public $id;

    /**
     * @var string Название компании
     */
    public $name;

    /**
     * @var string Дата и время создания компании
     */
    public $created_at;

    /**
     * @var string Дата и время изменения компании
     */
    public $updated_at;

    /**
     * @var integer id пользователя ответственного за компанию
     */
    public $responsible_user_id;

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

    /**
     * @param $array
     */
    public function set($array)
    {
        $this->setFromArray($this->fieldList, $array);
    }
}