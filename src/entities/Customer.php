<?php

namespace linkprofit\AmoCRM\entities;

/**
 * Class Customer
 * @package linkprofit\AmoCRM\entities
 */
class Customer extends CustomizableEntity
{
    /**
     * @var integer id покупателя, в которого будут вноситься изменения
     */
    public $id;

    /**
     * @var string Название покупателя
     */
    public $name;

    /**
     * @var string Дата и время следующей покупки
     */
    public $next_date;

    /**
     * @var string Дата и время создания покупателя
     */
    public $created_at;

    /**
     * @var string Дата и время изменения покупателя
     */
    public $updated_at;

    /**
     * @var integer ID ответственного пользователя
     */
    public $responsible_user_id;

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
     * @var string Уникальный идентификатор контакта, для связи с сделкой. Можно передавать несколько id, перечисляя их в строке через запятую.
     */
    public $contacts_id;

    /**
     * @var integer Уникальный идентификатор компании, для связи с сделкой
     */
    public $company_id;

    /**
     * @var array
     */
    protected $fieldList = [
        'id', 'name', 'next_date', 'created_at', 'updated_at',
        'responsible_user_id', 'created_by', 'next_price',
        'periodicity', 'tags', 'period_id', 'contacts_id', 'company_id'
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
    public function linkCompanyById($id)
    {
        $this->company_id = $id;
    }

    /**
     * @param $id
     */
    public function linkContactById($id)
    {
        $this->mergeStringToField($id, 'contacts_id');
    }
}