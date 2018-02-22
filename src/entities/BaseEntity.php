<?php

namespace linkprofit\AmoCRM\entities;

use linkprofit\AmoCRM\traits\FieldList;

/**
 * Class BaseEntity
 * @package entities
 */
abstract class BaseEntity implements EntityInterface
{
    /**
     * @var integer id сущности
     */
    public $id;

    /**
     * @var string Дата и время создания сущности
     */
    public $created_at;

    /**
     * @var string Дата и время изменения сущности
     */
    public $updated_at;

    /**
     * @var integer id пользователя ответственного за сущность
     */
    public $responsible_user_id;

    /**
     * @var array
     */
    protected $fieldList = [];

    use FieldList;

    /**
     * @return array
     */
    public function get()
    {
        if ($this->id) {
            $this->setUpdatedTime();
        }

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
     * Задаем время обновления, если уже не задано
     */
    protected function setUpdatedTime()
    {
        if (!$this->updated_at) {
            $this->updated_at = time();
        }
    }
}