<?php

use PHPUnit\Framework\TestCase;

class CompanyEntityTest extends TestCase
{
    public function testGet()
    {
        $company = $this->companyProvider();
        $this->assertEquals(['name' => 'Компания «Рога и копыта»', 'responsible_user_id' => 1924000], $company->get());
    }

    public function testCustomFieldsAdd()
    {
        $company = $this->companyProvider();

        $emailField = new \linkprofit\AmoCRM\entities\CustomField('146785', 'email', 'EMAIL');
        $emailField->addValue(new \linkprofit\AmoCRM\entities\Value(
                'email@email.com', '304683'
            )
        );

        $phoneField = new \linkprofit\AmoCRM\entities\CustomField('146783', 'Телефон', 'PHONE');
        $phoneField->addValue(new \linkprofit\AmoCRM\entities\Value(
                '89858881233', '304673'
        ));

        $company->addCustomField($emailField);
        $company->addCustomField($phoneField);

        $this->assertEquals(['name' => 'Компания «Рога и копыта»', 'responsible_user_id' => 1924000, 'custom_fields' => [
            $emailField->get(), $phoneField->get()
        ]], $company->get());
    }

    public function testLeadLink()
    {
        $company = $this->companyProvider();

        $company->linkLeadById(1);
        $this->assertEquals(['name' => 'Компания «Рога и копыта»', 'responsible_user_id' => 1924000, 'leads_id' => '1'], $company->get());

        $company->linkLeadById(2);
        $this->assertEquals(['name' => 'Компания «Рога и копыта»', 'responsible_user_id' => 1924000, 'leads_id' => '1,2'], $company->get());
    }

    public function testContactLink()
    {
        $company = $this->companyProvider();

        $company->linkContactById(1);
        $this->assertEquals(['name' => 'Компания «Рога и копыта»', 'responsible_user_id' => 1924000, 'contacts_id' => '1'], $company->get());

        $company->linkContactById(2);
        $this->assertEquals(['name' => 'Компания «Рога и копыта»', 'responsible_user_id' => 1924000, 'contacts_id' => '1,2'], $company->get());
    }

    protected function companyProvider()
    {
        $company = new \linkprofit\AmoCRM\entities\Company();
        $company->responsible_user_id = 1924000;
        $company->name = 'Компания «Рога и копыта»';

        return $company;
    }
}