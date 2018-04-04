<?php

namespace linkprofit\AmoCRM\tests\providers;


class ContactProvider
{
    public function getContact()
    {
        $contact = new \linkprofit\AmoCRM\entities\Contact();
        $contact->responsible_user_id = 1924000;
        $contact->name = 'Василий Аркадьевич';

        return $contact;
    }
}