<?php

namespace linkprofit\AmoCRM\entities;

/**
 * Class Task
 * @package linkprofit\AmoCRM\entities
 */
class Task extends LinkElementCapableEntity implements LinkableElement
{
    /**
     * Задача. Для задачи доступен только тип события TASK_RESULT
     */
    const ELEMENT_TYPE = 4;


    /**
     * Результат по задаче
     */
    const TASK_RESULT = 13;


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
     * @param $entityClass
     *
     * @return bool
     */
    public function supports($entityClass)
    {
        $supportedClasses = [Note::class];

        return in_array($entityClass, $supportedClasses, 1) && !empty($this->id);
    }

    /**
     * @param LinkElementCapableEntity $entity
     *
     * @return LinkElementCapableEntity
     */
    public function linkSelf(LinkElementCapableEntity $entity)
    {
        $entity->element_type = self::ELEMENT_TYPE;
        $entity->element_id = $this->id;

        if ($entity instanceof Note) {
            $entity->note_type = Task::TASK_RESULT;
        }

        return $entity;
    }
}