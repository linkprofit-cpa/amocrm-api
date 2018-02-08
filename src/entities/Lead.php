<?php

namespace linkprofit\AmoCRM\entities;

/**
 * Class Lead
 * @package linkprofit\AmoCRM\entities
 */
class Lead extends CustomizableEntity
{
    /**
     * @var integer id сделки, в которую будут вноситься изменения
     */
    public $id;

    /**
     * @var string Название сделки
     */
    public $name;

    /**
     * @var string Дата создания текущей сделки
     */
    public $created_at;

    /**
     * @var string Дата изменения текущей сделки
     */
    public $updated_at;

    /**
     * @var integer Статус сделки (id этапа продаж см. Воронки и этапы продаж) Чтобы перенести сделку в другую воронку, необходимо установить ей статус из нужной воронки
     */
    public $status_id;

    /**
     * @var integer ID воронки. Указывается в том случае, если выбраны статусы id 142 или 143, т.к. эти статусы не уникальны и обязательны для всех цифровых воронок.
     */
    public $pipeline_id;

    /**
     * @var integer ID ответственного пользователя
     */
    public $responsible_user_id;

    /**
     * @var integer Бюджет сделки
     */
    public $sale;

    /**
     * @var string Если вы хотите задать новые теги, перечислите их внутри строковой переменной через запятую
     */
    public $tags;

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
        'id', 'name', 'created_at', 'updated_at',
        'status_id', 'pipeline_id', 'responsible_user_id',
        'sale', 'tags', 'contacts_id', 'company_id'
    ];

    /**
     * @param $array
     */
    public function set($array)
    {
        $this->setFromArray($this->fieldList, $array);
    }
}