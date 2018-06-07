<?php

namespace linkprofit\AmoCRM\entities;

use linkprofit\AmoCRM\traits\CompanyLinkable;
use linkprofit\AmoCRM\traits\LeadsLinkable;

/**
 * Class Contact
 * @package linkprofit\AmoCRM\entities
 */
class Contact extends CustomizableEntity implements LinkableElement
{
    /**
     * Контакт
     */
    const ELEMENT_TYPE = 1;

    /**
     * @var string Название контакта
     */
    public $name;

    /**
     * @var integer id пользователя создавшего контакт
     */
    public $created_by;

    /**
     * @var string Название новой компании. Параметр указывается для создания новой компании и привязке к ней контакта. Для привязки контакта к уже существующей компании, необходимо использовать параметр company_id
     */
    public $company_name;

    /**
     * @var string Теги, привязываемые к контакту. Задаются целостной строковой переменной, внутри строки перечисляются через запятую
     */
    public $tags;

    /**
     * @var string Покупатели, привязываемые к контакту. Перечисляются через запятую.
     */
    public $customers_id;

    /**
     * @var array
     */
    protected $fieldList = [
        'id', 'name', 'created_at', 'updated_at',
        'responsible_user_id', 'created_by', 'company_name',
        'tags', 'leads_id', 'customers_id', 'company_id',
    ];

    use CompanyLinkable,
        LeadsLinkable;

    /**
     * @param $entityClass
     *
     * @return bool
     */
    public function supports($entityClass)
    {
        $supportedClasses = [Task::class, Note::class];

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

        return $entity;
    }
}