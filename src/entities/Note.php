<?php

namespace linkprofit\AmoCRM\entities;

/**
 * Class Note
 * @package linkprofit\AmoCRM\entities
 */
class Note extends LinkElementCapableEntity
{
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
    const SMS_OUT = 103;

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
     * @var int Массив с передаваемой информацией для определённых типов событий
     */
    public $params;

    /**
     * @var array
     */
    protected $fieldList = [
        'id', 'element_id', 'element_type', 'note_type',
        'text', 'created_at', 'updated_at', 'responsible_user_id',
        'params'
    ];
}
