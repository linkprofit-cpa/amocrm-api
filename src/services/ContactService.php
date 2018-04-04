<?php

namespace linkprofit\AmoCRM\services;

use linkprofit\AmoCRM\entities\Contact;
use linkprofit\AmoCRM\entities\EntityInterface;

/**
 * Class ContactService
 * @package linkprofit\AmoCRM\services
 */
class ContactService extends BaseService
{
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