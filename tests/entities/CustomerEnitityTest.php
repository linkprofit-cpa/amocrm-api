<?php

namespace linkprofit\AmoCRM\tests\entities;

use PHPUnit\Framework\TestCase;
use linkprofit\AmoCRM\tests\providers\CustomFieldProvider;
use linkprofit\AmoCRM\tests\providers\CustomerProvider;

class CustomerEntityTest extends TestCase
{
    /**
     * @var CustomerProvider
     */
    protected $customer;

    /**
     * @var CustomFieldProvider
     */
    protected $customField;

    public function testGet()
    {
        $customer = $this->customer->getCustomer();
        $this->assertEquals(['responsible_user_id' => 1924000, 'created_by' => 1924000, 'name' => 'Новый покупатель'], $customer->get());
    }

    public function testCustomFieldAdd()
    {
        $customer = $this->customer->getCustomer();

        $customField = $this->customField->getEmailField();
        $customer->addCustomField($customField);

        $this->assertEquals(['responsible_user_id' => 1924000, 'created_by' => 1924000, 'name' => 'Новый покупатель', 'custom_fields' => [
           $customField->get()
        ]], $customer->get());
    }

    protected function setUp()
    {
       $this->customField = new CustomFieldProvider();
       $this->customer = new CustomerProvider();
    }
}