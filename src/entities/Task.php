<?php

namespace linkprofit\AmoCRM\entities;

/**
 * Class Task
 * @package linkprofit\AmoCRM\entities
 */
class Task extends BaseEntity
{
    /**
     * Контакт
     */
    const CONTACT_ELEMENT_TYPE = 1;

    /**
     * Сделка
     */
    const LEAD_ELEMENT_TYPE = 2;

    /**
     * Компания
     */
    const COMPANY_ELEMENT_TYPE = 3;

    /**
     * Покупатель
     */
    const CUSTOMER_ELEMENT_TYPE = 12;


    /**
     * Звонок
     */
    const CALL_TASK_TYPE = 1;

    /**
     * Встреча
     */
    const MEETING_TASK_TYPE = 2;

    /**
     * Написать письмо
     */
    const MAIL_TASK_TYPE = 3;


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

    /**
     * @param BaseEntity $element
     * @return bool
     */
    public function linkElement(BaseEntity $element)
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