<?php

namespace linkprofit\AmoCRM\traits;

/**
 * Class ContactsLinkable
 * @package linkprofit\AmoCRM\traits
 */
trait ContactsLinkable
{
    /**
     * @var string Уникальный идентификатор контакта, для связи с cущностью. Можно передавать несколько id, перечисляя их в строке через запятую.
     */
    public $contacts_id;

    use FieldsMergeable;

    /**
     * @param $id
     */
    public function linkContactById($id)
    {
        $this->mergeStringToField($id, 'contacts_id');
    }
}