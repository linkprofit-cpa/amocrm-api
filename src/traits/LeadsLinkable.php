<?php

namespace linkprofit\AmoCRM\traits;

/**
 * Class LeadsLinkable
 * @package linkprofit\AmoCRM\traits
 */
trait LeadsLinkable
{
    /**
     * @var string Уникальный идентификатор контакта, для связи с cущностью. Можно передавать несколько id, перечисляя их в строке через запятую.
     */
    public $leads_id;

    use FieldsMergeable;

    /**
     * @param $id
     */
    public function linkLeadById($id)
    {
        $this->mergeStringToField($id, 'leads_id');
    }
}