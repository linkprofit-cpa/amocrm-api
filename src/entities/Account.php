<?php

namespace linkprofit\AmoCRM\entities;

use linkprofit\AmoCRM\traits\CompanyLinkable;
use linkprofit\AmoCRM\traits\FieldList;
use linkprofit\AmoCRM\traits\LeadsLinkable;

/**
 * Class Contact
 * @package linkprofit\AmoCRM\entities
 */
class Account implements EntityInterface
{
    use FieldList;
    /**
     * @var int Уникальный идентификатор аккаунта
     */
    public $id;

    /**
     * @var string Название аккаунта
     */
    public $name;

    /**
     * @var string Уникальный субдомен данного аккаунта
     */
    public $subdomain;

    /**
     * @var string Валюта аккаунта (используемая при работе с бюджетом сделок). Не связано с биллинговой информацией самого аккаунта.
     */
    public $currency;

    /**
     * @var string Временная зона
     */
    public $timezone;

    /**
     * @var string Cмещение временной зоны
     */
    public $timezone_offset;

    /**
     * @var string Язык аккаунта (ru - русский, en - английский)
     */
    public $language;

    /**
     * @var int id текущего пользователя
     */
    public $current_user;

    /**
     * @var array
     */
    protected $fieldList = [
        'id', 'name', 'subdomain', 'currency',
        'timezone', 'timezone_offset', 'language', 'current_user'
    ];

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
}