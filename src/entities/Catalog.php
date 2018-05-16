<?php

namespace linkprofit\AmoCRM\entities;

/**
 * Class Catalog
 *
 * @package linkprofit\AmoCRM\entities
 */
class Catalog extends BaseEntity
{
    /**
     * Тип списка стандартный список
     */
    const CATALOG_TYPE_REGULAR = 'regular';

    /**
     * Тип списка список счетов - в аккаунте может существовать только один список счетов
     */
    const CATALOG_TYPE_INVOICES = 'invoices';

    /**
     * @var string Название списка
     */
    public $name;

    /**
     * @var string Тип списка
     * "regular" - список,
     * "invoices" - счета
     */
    public $type = self::CATALOG_TYPE_REGULAR;

    /**
     * @var bool Добавление элемента списка из интерфейса
     */
    public $can_add_elements = true;

    /**
     * @var bool Возможность добавить вкладку со списком в карточку сделки/покупателя
     */
    public $can_show_in_cards = true;

    /**
     * @var bool Возможность привязывать один элемент данного списка к нескольким сделкам/покупателям
     */
    public $can_link_multiple = true;

    /**
     * @var array
     */
    protected $fieldList = [
        'id', 'name', 'type', 'can_add_elements', 'can_show_in_cards',
        'can_link_multiple',
    ];
}