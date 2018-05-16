<?php

namespace linkprofit\AmoCRM\entities;

use linkprofit\AmoCRM\traits\CompanyLinkable;
use linkprofit\AmoCRM\traits\ContactsLinkable;

/**
 * Class Lead
 * @package linkprofit\AmoCRM\entities
 */
class Lead extends CustomizableEntity
{
    /**
     * @var string Название сделки
     */
    public $name;

    /**
     * @var integer Статус сделки (id этапа продаж см. Воронки и этапы продаж) Чтобы перенести сделку в другую воронку, необходимо установить ей статус из нужной воронки
     */
    public $status_id;

    /**
     * @var integer ID воронки. Указывается в том случае, если выбраны статусы id 142 или 143, т.к. эти статусы не уникальны и обязательны для всех цифровых воронок.
     */
    public $pipeline_id;

    /**
     * @var integer Бюджет сделки
     */
    public $sale;

    /**
     * @var string Если вы хотите задать новые теги, перечислите их внутри строковой переменной через запятую
     */
    public $tags;

    /**
     * @var int Id пользователя изменившего сущность, если 0, то робот
     */
    public $modified_user_id;

    /**
     * @var array
     */
    protected $fieldList = [
        'id', 'name', 'created_at', 'updated_at',
        'status_id', 'pipeline_id', 'responsible_user_id',
        'sale', 'tags', 'contacts_id', 'company_id',
        'modified_user_id'
    ];

    use CompanyLinkable,
        ContactsLinkable;
}