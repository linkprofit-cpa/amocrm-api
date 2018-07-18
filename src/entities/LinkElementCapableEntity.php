<?php

namespace linkprofit\AmoCRM\entities;

/**
 * Class LinkElementCapableEntity
 * @package linkprofit\AmoCRM\entities
 */
abstract class LinkElementCapableEntity extends BaseEntity
{
    /**
     * @var int Уникальный идентификатор контакта или сделки (сделка или контакт указывается в element_type)
     */
    public $element_id;

    /**
     * @var int Тип привязываемого элемента (1 - контакт, 2- сделка, 3 - компания, 12 - покупатель)
     */
    public $element_type;

    /**
     * @param LinkableElement $element
     *
     * @return bool
     */
    public function linkElement(LinkableElement $element)
    {
        if (!$element->supports(get_called_class())) {
            return false;
        }

        $element->linkSelf($this);

        return true;
    }
}