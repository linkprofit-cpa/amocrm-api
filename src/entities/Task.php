<?php

namespace linkprofit\AmoCRM\entities;

use linkprofit\AmoCRM\traits\FieldsTrait;

/**
 * Class Task
 * @package linkprofit\AmoCRM\entities
 */
class Task implements EntityInterface
{
    const CONTACT_ELEMENT_TYPE = 1;
    const LEAD_ELEMENT_TYPE = 2;
    const COMPANY_ELEMENT_TYPE = 3;
    const CUSTOMER_ELEMENT_TYPE = 12;

    const CALL_TASK_TYPE = 1;
    const MEETING_TASK_TYPE = 2;
    const MAIL_TASK_TYPE = 3;


    /**
     * @var int Уникальный идентификатор обновляемой задачи
     */
    public $id;

    /**
     * @var int Уникальный идентификатор контакта или сделки (сделка или контакт указывается в element_type)
     */
    public $element_id;

    /**
     * @var int Тип привязываемого элемента (1 - контакт, 2- сделка, 3 - компания, 12 - покупатель)
     */
    public $element_type;

    /**
     * @var string Дата, до которой необходимо завершить задачу. Если указано время 23:59, то в интерфейсах системы вместо времени будет отображаться "Весь день".
     */
    public $complete_till_at;

    /**
     * @var int Тип задачи
     */
    public $task_type;

    /**
     * @var string Текст задачи
     */
    public $text;

    /**
     * @var string Дата создания данной задачи (необязательный параметр)
     */
    public $created_at;

    /**
     * @var string Дата последнего изменения данной задачи (обязательный параметр при обновлении)
     */
    public $updated_at;

    /**
     * @var int Уникальный идентификатор ответственного пользователя
     */
    public $responsible_user_id;

    /**
     * @var bool Задача завершена или нет
     */
    public $is_completed;

    /**
     * @var array
     */
    protected $fieldList = [
        'id', 'element_id', 'element_type', 'complete_till_at', 'task_type',
        'text', 'created_at', 'updated_at', 'responsible_user_id', 'is_completed'
    ];

    use FieldsTrait;

    /**
     * @return array
     */
    public function get()
    {
        $fields = $this->getExistedValues($this->fieldList);

        return $fields;
    }

    /**
     * @param $array
     */
    public function set($array)
    {
        $this->setFromArray($this->fieldList, $array);
    }

    /**
     * @param EntityInterface $element
     * @return bool
     */
    public function linkElement(EntityInterface $element)
    {
        if (empty($element->id)) {
            return false;
        }

        if ($element instanceof Contact) {
            $this->element_type = self::CONTACT_ELEMENT_TYPE;
        } elseif ($element instanceof Lead) {
            $this->element_type = self::LEAD_ELEMENT_TYPE;
        } else {
            return false;
        }

        $this->element_id = $element->id;

        return true;
    }
}