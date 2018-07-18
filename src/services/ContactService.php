<?php

namespace linkprofit\AmoCRM\services;

use linkprofit\AmoCRM\entities\Contact;
use linkprofit\AmoCRM\entities\EntityInterface;
use linkprofit\AmoCRM\traits\IdentifiableList;
use linkprofit\AmoCRM\traits\PaginableList;
use linkprofit\AmoCRM\traits\TermList;

/**
 * Class ContactService
 * @package linkprofit\AmoCRM\services
 */
class ContactService extends BaseService
{
    use IdentifiableList,
        TermList,
        PaginableList;

    /**
     * @var Contact[]
     */
    protected $entities = [];

    /**
     * @param Contact $contact
     */
    public function add(EntityInterface $contact)
    {
        if ($contact instanceof Contact) {
            $this->entities[] = $contact;
        }
    }

    /**
     * @param $link
     *
     * @return string
     */
    protected function composeListLink($link)
    {
        $query = $this->addTermToQuery();
        $query = $this->addIdToQuery($query);
        $query = $this->addPaginationToQuery($query);

        $link .= '?' . http_build_query($query);

        return $link;
    }

    /**
     * @param $array
     * @return Contact
     */
    public function parseArrayToEntity($array)
    {
        $contact = new Contact();
        $contact->set($array);

        return $contact;
    }

    /**
     * @return string
     */
    protected function getLink()
    {
        return 'https://' . $this->request->getSubdomain() . '.amocrm.ru/api/v2/contacts';
    }
}