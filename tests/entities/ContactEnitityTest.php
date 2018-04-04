<?php

namespace linkprofit\AmoCRM\tests\entities;

use PHPUnit\Framework\TestCase;
use linkprofit\AmoCRM\tests\providers\CustomFieldProvider;
use linkprofit\AmoCRM\tests\providers\ContactProvider;

class ContactEntityTest extends TestCase
{
    /**
     * @var CustomFieldProvider
     */
    protected $customField;

    /**
     * @var ContactProvider
     */
    protected $contact;

    public function testGet()
    {
        $contact = $this->contact->getContact();
        $this->assertEquals(['name' => 'Василий Аркадьевич', 'responsible_user_id' => 1924000], $contact->get());
    }

    public function testGetWithId()
    {
        $contact = $this->contact->getContact();
        $contact->id = 2;
        $contactArray = $contact->get();
        $this->assertEquals(['id' => 2, 'name' => 'Василий Аркадьевич', 'responsible_user_id' => 1924000, 'updated_at' => $contact->updated_at], $contactArray);
    }

    public function testCustomFieldsAdd()
    {
        $contact = $this->contact->getContact();

        $emailField = $this->customField->getEmailField();
        $phoneField = $this->customField->getPhoneField();

        $contact->addCustomField($emailField);
        $contact->addCustomField($phoneField);

        $this->assertEquals(['name' => 'Василий Аркадьевич', 'responsible_user_id' => 1924000, 'custom_fields' => [
            $emailField->get(), $phoneField->get()
        ]], $contact->get());
    }

    public function testLeadLink()
    {
        $contact = $this->contact->getContact();

        $contact->linkLeadById(1);
        $this->assertEquals(['name' => 'Василий Аркадьевич', 'responsible_user_id' => 1924000, 'leads_id' => '1'], $contact->get());

        $contact->linkLeadById(2);
        $this->assertEquals(['name' => 'Василий Аркадьевич', 'responsible_user_id' => 1924000, 'leads_id' => '1,2'], $contact->get());
    }

    public function testCompanyLink()
    {
        $contact = $this->contact->getContact();

        $contact->linkCompanyById(1);
        $this->assertEquals(['name' => 'Василий Аркадьевич', 'responsible_user_id' => 1924000, 'company_id' => '1'], $contact->get());
    }

    protected function setUp()
    {
        $this->customField = new CustomFieldProvider();
        $this->contact = new ContactProvider();
    }
}