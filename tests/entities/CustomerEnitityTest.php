<?php

use PHPUnit\Framework\TestCase;

class CustomerEntityTest extends TestCase
{
    public function testGet()
    {
        $customer = $this->customerProvider();
        $this->assertEquals(['responsible_user_id' => 1924000, 'created_by' => 1924000, 'name' => 'Новый покупатель'], $customer->get());
    }

    public function testCustomFieldAdd()
    {
        $customer = $this->customerProvider();

        $customField = $this->emailFieldProvider();
        $customer->addCustomField($customField);

        $this->assertEquals(['responsible_user_id' => 1924000, 'created_by' => 1924000, 'name' => 'Новый покупатель', 'custom_fields' => [
           $customField->get()
        ]], $customer->get());
    }

    protected function emailFieldProvider()
    {
        $customField = new \linkprofit\AmoCRM\entities\CustomField('146785', 'email', 'EMAIL');
        $customField->addValue(new \linkprofit\AmoCRM\entities\Value(
                'email@email.com', '304683'
            )
        );

        return $customField;
    }

    protected function customerProvider()
    {
        $customer = new \linkprofit\AmoCRM\entities\Customer();
        $customer->created_by = 1924000;
        $customer->responsible_user_id = 1924000;
        $customer->name = 'Новый покупатель';

        return $customer;
    }
}