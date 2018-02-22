<?php

namespace linkprofit\AmoCRM\tests\entities;

use linkprofit\AmoCRM\tests\providers\LeadProvider;
use linkprofit\AmoCRM\tests\providers\CustomFieldProvider;
use PHPUnit\Framework\TestCase;

class LeadEntityTest extends TestCase
{
    /**
     * @var LeadProvider
     */
    protected $lead;

    /**
     * @var CustomFieldProvider
     */
    protected $customField;

    public function testGet()
    {
        $lead = $this->lead->getLead();
        $this->assertEquals(['status_id' => '17077744', 'sale' => 0, 'responsible_user_id' => 1924000], $lead->get());
    }

    public function testGetWithId()
    {
        $lead = $this->lead->getLead();
        $lead->id = 2;
        $leadArray = $lead->get();
        $this->assertEquals(['id' => 2, 'status_id' => '17077744', 'sale' => 0, 'responsible_user_id' => 1924000, 'updated_at' => $lead->updated_at], $leadArray);
    }

    public function testCustomFieldAdd()
    {
        $lead = $this->lead->getLead();

        $customField = $this->customField->getEmailField();
        $lead->addCustomField($customField);

        $this->assertEquals(['status_id' => '17077744', 'sale' => 0, 'responsible_user_id' => 1924000, 'custom_fields' => [
           $customField->get()
        ]], $lead->get());
    }

    protected function setUp()
    {
       $this->lead = new LeadProvider();
       $this->customField = new CustomFieldProvider();
    }
}