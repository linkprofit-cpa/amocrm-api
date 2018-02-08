<?php

namespace linkprofit\AmoCRM\entities;

/**
 * Class Lead
 * @package linkprofit\AmoCRM\entities
 */
class Contact extends CustomizableEntity
{
    /**
     * @var integer id контакта, в которого будут вноситься изменения
     */
    public $id;

    /**
     * @var string Название контакта
     */
    public $name;

    /**
     * @var string Дата и время создания контакта
     */
    public $created_at;

    /**
     * @var string Дата и время обновления контакта. Обязательно при обновлении сущности.
     */
    public $updated_at;

    /**
     * @var integer id пользователя ответственного за контакт
     */
    public $responsible_user_id;

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
     * @var string Сделки, привязываемые к контакту. Перечисляются через запятую.
     */
    public $leads_id;

    /**
     * @var string Покупатели, привязываемые к контакту. Перечисляются через запятую.
     */
    public $customers_id;

    /**
     * @var string Компании, привязываемые к контакту. Перечисляются через запятую.
     */
    public $company_id;

    /**
     * @var array
     */
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

    /**
     * @param $id
     */
    public function linkLeadById($id)
    {
        $this->mergeStringToField('leads_id', $id);
    }
}