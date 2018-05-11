<?php

namespace linkprofit\AmoCRM\entities;

/**
 * Class Task
 * @package linkprofit\AmoCRM\entities
 */
class TaskType extends BaseEntity
{
    /**
     * @var string Название типа сделки
     */
    public $name;

    /**
     * @var array
     */
    protected $fieldList = [
        'id', 'name'
    ];
}