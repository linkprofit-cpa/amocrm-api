<?php

namespace linkprofit\AmoCRM\entities;

use linkprofit\AmoCRM\traits\FieldList;

/**
 * Class Status
 * @package linkprofit\AmoCRM\entities
 */
class Status implements EntityInterface
{
    /**
     * Статус Успешно
     */
    const SUCCESS = 142;

    /**
     * Статус Провалено
     */
    const FAILED = 143;

    /**
     * @var integer Уникальный идентификатор этапа
     */
    public $id;

    /**
     * @var string Название этапа
     */
    public $name;

    /**
     * @var int Порядковый номер этапа при отображении (автоматически пересчитывается после добавления)
     */
    public $sort;

    /**
     * @var string Цвет этапа (подробнее можно узнать здесь)
     */
    public $color;

    /**
     * @var array
     */
    protected $fieldList = ['name', 'sort', 'color'];

    use FieldList;

    /**
     * @return array
     */
    public function get()
    {
        if (in_array($this->id, [Status::SUCCESS, Status::FAILED]) && $this->name) {
            return [$this->id => ['name' => $this->name]];
        }
        $values = $this->getExistedValues($this->fieldList);

        if ($this->id) {
            return [$this->id => $values];
        }

        return $values;
    }
}