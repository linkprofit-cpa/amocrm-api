<?php

namespace linkprofit\AmoCRM\entities;

use linkprofit\AmoCRM\traits\StatusAddable;

/**
 * Class Pipeline
 * @package linkprofit\AmoCRM\entities
 */
class Pipeline extends BaseEntity
{
    /**
     * @var string Имя воронки
     */
    public $name;

    /**
     * @var integer Порядковый номер воронки при отображении
     */
    public $sort;

    /**
     * @var string Является ли воронка "главной" (необходимо передать значение "on", если является)
     */
    public $is_main;

    /**
     * @var array
     */
    protected $fieldList = ['id', 'name', 'sort', 'is_main'];

    use StatusAddable;

    /**
     * @return array
     */
    public function get()
    {
        $statuses = [];
        foreach ($this->statuses as $status) {
            $statuses[] = $status->get();
        }

        $fields = $this->getExistedValues($this->fieldList);

        if (count($statuses)) {
            $fields['statuses'] = $statuses;
        }

        return $fields;
    }
}