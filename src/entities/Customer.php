<?php

namespace linkprofit\AmoCRM\entities;

use linkprofit\AmoCRM\traits\CompanyLinkable;
use linkprofit\AmoCRM\traits\ContactsLinkable;

/**
 * Class Customer
 * @package linkprofit\AmoCRM\entities
 */
class Customer extends CustomizableEntity
{
    /**
     * @var string Название покупателя
     */
    public $name;

    /**
     * @var string Дата и время следующей покупки
     */
    public $next_date;

    /**
     * @var integer id пользователя создавшего покупателя
     */
    public $created_by;

    /**
     * @var integer Ожидаемая сумма
     */
    public $next_price;

    /**
     * @var integer Периодичность совершаемых покупок
     */
    public $periodicity;

    /**
     * @var string Если вы хотите задать новые теги, перечислите их внутри строковой переменной через запятую
     */
    public $tags;

    /**
     * @var integer id периода цифровой воронки покупателя
     */
    public $period_id;

    /**
     * @var array
     */
    protected $fieldList = [
        'id', 'name', 'next_date', 'created_at', 'updated_at',
        'responsible_user_id', 'created_by', 'next_price',
        'periodicity', 'tags', 'period_id', 'contacts_id', 'company_id'
    ];

    use CompanyLinkable,
        ContactsLinkable;
}