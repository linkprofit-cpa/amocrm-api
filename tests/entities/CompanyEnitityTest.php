<?php

namespace linkprofit\AmoCRM\tests\entities;

use PHPUnit\Framework\TestCase;
use linkprofit\AmoCRM\tests\providers\CustomFieldProvider;
use linkprofit\AmoCRM\tests\providers\CompanyProvider;

class CompanyEntityTest extends TestCase
{
    /**
     * @var CustomFieldProvider
     */
    protected $customField;

    /**
     * @var CompanyProvider
     */
    protected $company;

    public function testGet()
    {
        $company = $this->company->getCompany();
        $this->assertEquals(['name' => 'Компания «Рога и копыта»', 'responsible_user_id' => 1924000], $company->get());
    }

    public function testGetWithId()
    {
        $company = $this->company->getCompany();
        $company->id = 2;
        $companyArray = $company->get();
        $this->assertEquals(['id' => 2, 'name' => 'Компания «Рога и копыта»', 'responsible_user_id' => 1924000, 'updated_at' => $company->updated_at], $companyArray);
    }

    public function testCustomFieldsAdd()
    {
        $company = $this->company->getCompany();

        $emailField = $this->customField->getEmailField();
        $phoneField = $this->customField->getPhoneField();

        $company->addCustomField($emailField);
        $company->addCustomField($phoneField);

        $this->assertEquals(['name' => 'Компания «Рога и копыта»', 'responsible_user_id' => 1924000, 'custom_fields' => [
            $emailField->get(), $phoneField->get()
        ]], $company->get());
    }

    public function testLeadLink()
    {
        $company = $this->company->getCompany();

        $company->linkLeadById(1);
        $this->assertEquals(['name' => 'Компания «Рога и копыта»', 'responsible_user_id' => 1924000, 'leads_id' => '1'], $company->get());

        $company->linkLeadById(2);
        $this->assertEquals(['name' => 'Компания «Рога и копыта»', 'responsible_user_id' => 1924000, 'leads_id' => '1,2'], $company->get());
    }

    public function testContactLink()
    {
        $company = $this->company->getCompany();

        $company->linkContactById(1);
        $this->assertEquals(['name' => 'Компания «Рога и копыта»', 'responsible_user_id' => 1924000, 'contacts_id' => '1'], $company->get());

        $company->linkContactById(2);
        $this->assertEquals(['name' => 'Компания «Рога и копыта»', 'responsible_user_id' => 1924000, 'contacts_id' => '1,2'], $company->get());
    }

    protected function setUp()
    {
        $this->customField = new CustomFieldProvider();
        $this->company = new CompanyProvider();
    }
}