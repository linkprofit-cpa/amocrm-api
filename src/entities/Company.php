<?php

namespace linkprofit\AmoCRM\entities;

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
     * @var string Сделки, привязываемые к компании. Перечисляются через запятую.
     */
    public $leads_id;

    /**
     * @var string Покупатели, привязываемые к компании. Перечисляются через запятую.
     */
    public $customers_id;

    /**
     * @var string Контакты, привязываемые к компании. Перечисляются id через запятую.
     */
    public $contacts_id;

    /**
     * @var array
     */
    protected $fieldList = [
        'id', 'name', 'created_at', 'updated_at',
        'responsible_user_id', 'created_by', 'tags',
        'leads_id', 'customers_id', 'contacts_id',
    ];

    /**
     * @param $array
     */
    public function set($array)
    {
        $this->setFromArray($this->fieldList, $array);
    }

    /**
     * @param $id
     */
    public function linkLeadById($id)
    {
        $this->mergeStringToField($id, 'leads_id');
    }

    /**
     * @param $id
     */
    public function linkContactById($id)
    {
        $this->mergeStringToField($id, 'contacts_id');
    }
}