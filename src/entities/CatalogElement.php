<?php

namespace linkprofit\AmoCRM\entities;

/**
 * Class CatalogElement
 *
 * @package linkprofit\AmoCRM\entities
 */
class CatalogElement extends CustomizableEntity
{
    /**
     * @var string Название списка
     */
    public $name;

    /**
     * @var int ID списка
     */
    public $catalog_id;

    /**
     * @var int Уникальный идентификатор записи в клиентской программе, необязательный параметр (информация о request_id нигде не сохраняется)
     */
    public $request_id;

    /**
     * @var array
     */
    protected $fieldList = [
        'id', 'name', 'catalog_id', 'request_id',
    ];
}