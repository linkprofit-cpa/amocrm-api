<?php

use PHPUnit\Framework\TestCase;

class ContactEntityTest extends TestCase
{
    public function testGet()
    {
        $contact = $this->contactProvider();
        $this->assertEquals(['name' => 'Василий Аркадьевич', 'responsible_user_id' => 1924000], $contact->get());
    }

    public function testCustomFieldsAdd()
    {
        $contact = $this->contactProvider();

        $emailField = new \linkprofit\AmoCRM\entities\CustomField('146785', 'email', 'EMAIL');
        $emailField->addValue(new \linkprofit\AmoCRM\entities\Value(
                'email@email.com', '304683'
            )
        );

        $phoneField = new \linkprofit\AmoCRM\entities\CustomField('146783', 'Телефон', 'PHONE');
        $phoneField->addValue(new \linkprofit\AmoCRM\entities\Value(
                '89858881233', '304673'
        ));

        $contact->addCustomField($emailField);
        $contact->addCustomField($phoneField);

        $this->assertEquals(['name' => 'Василий Аркадьевич', 'responsible_user_id' => 1924000, 'custom_fields' => [
            $emailField->get(), $phoneField->get()
        ]], $contact->get());
    }

    public function testLeadLink()
    {
        $contact = $this->contactProvider();

        $contact->linkLeadById(1);
        $this->assertEquals(['name' => 'Василий Аркадьевич', 'responsible_user_id' => 1924000, 'leads_id' => '1'], $contact->get());

        $contact->linkLeadById(2);
        $this->assertEquals(['name' => 'Василий Аркадьевич', 'responsible_user_id' => 1924000, 'leads_id' => '1,2'], $contact->get());
    }

    public function testCompanyLink()
    {
        $contact = $this->contactProvider();

        $contact->linkCompanyById(1);
        $this->assertEquals(['name' => 'Василий Аркадьевич', 'responsible_user_id' => 1924000, 'company_id' => '1'], $contact->get());
    }

    protected function contactProvider()
    {
        $contact = new \linkprofit\AmoCRM\entities\Contact();
        $contact->responsible_user_id = 1924000;
        $contact->name = 'Василий Аркадьевич';

        return $contact;
    }
}