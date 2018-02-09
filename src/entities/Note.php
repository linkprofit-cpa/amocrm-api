<?php

namespace linkprofit\AmoCRM\entities;

use linkprofit\AmoCRM\traits\FieldsTrait;

/**
 * Class Note
 * @package linkprofit\AmoCRM\entities
 */
class Note implements EntityInterface
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
     * Задача. Для задачи доступен только тип события TASK_RESULT
     */
    const TASK_ELEMENT_TYPE = 4;

    /**
     * Покупатель
     */
    const CUSTOMER_ELEMENT_TYPE = 12;


    /**
     * Сделка создана
     */
    const DEAL_CREATED = 1;

    /**
     * Контакт создан
     */
    const CONTACT_CREATED = 2;

    /**
     * Статус сделки изменен
     */
    const DEAL_STATUS_CHANGED = 3;

    /**
     * Обычное примечание
     */
    const COMMON = 4;

    /**
     * Входящий звонок
     */
    const CALL_IN = 10;

    /**
     * Исходящий звонок
     */
    const CALL_OUT = 11;

    /**
     * Компания создана
     */
    const COMPANY_CREATED = 12;

    /**
     * Результат по задаче
     */
    const TASK_RESULT = 13;

    /**
     * Системное сообщение
     */
    const SYSTEM = 25;

    /**
     * Входящее смс
     */
    const SMS_IN = 102;

    /**
     * Исходящее смс
     */
    const SMS_OUT = 102;


    /**
     * @var int Уникальный идентификатор обновляемой задачи
     */
    public $id;

    /**
     * @var int id элемента, в карточку которого будет добавлено событие
     */
    public $element_id;

    /**
     * @var int Тип сущности элемента, в карточку которого будет добавлено событие.
     */
    public $element_type;

    /**
     * @var string Текст события
     */
    public $text;

    /**
     * @var integer Тип добавляемого события
     */
    public $note_type;

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
     * @var int Массив с передаваемой информацией для определённых типов событий
     */
    public $params;

    /**
     * @var array
     */
    protected $fieldList = [
        'id', 'element_id', 'element_type', 'note_type',
        'text', 'created_at', 'updated_at', 'responsible_user_id'
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
        $className = get_class($element);
        switch ($className) {
            case Contact::class:
                $this->element_type = self::CONTACT_ELEMENT_TYPE;
                break;
            case Lead::class:
                $this->element_type = self::LEAD_ELEMENT_TYPE;
                break;
            case Task::class:
                $this->element_type = self::TASK_ELEMENT_TYPE;
                $this->note_type = self::TASK_RESULT;
                break;
            default:
                return false;
        }

        if (empty($element->id)) {
            return false;
        }

        $this->element_id = $element->id;

        return true;
    }
}