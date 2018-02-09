<?php

use PHPUnit\Framework\TestCase;

class LeadEntityTest extends TestCase
{
    public function testGet()
    {
        $lead = new \linkprofit\AmoCRM\entities\Lead();
        $lead->status_id = 17077744;
        $lead->sale = 0;
        $lead->responsible_user_id = 1924000;

        $this->assertEquals(['status_id' => '17077744', 'sale' => 0, 'responsible_user_id' => 1924000], $lead->get());
    }

    public function testCustomFieldAdd()
    {
        $lead = new \linkprofit\AmoCRM\entities\Lead();
        $lead->status_id = 17077744;
        $lead->sale = 0;
        $lead->responsible_user_id = 1924000;

        $customField = new \linkprofit\AmoCRM\entities\CustomField('146785', 'email', 'EMAIL');
        $customField->addValue(new \linkprofit\AmoCRM\entities\Value(
                'email@email.com', '304683'
            )
        );

        $lead->addCustomField($customField);

        $this->assertEquals(['status_id' => '17077744', 'sale' => 0, 'responsible_user_id' => 1924000, 'custom_fields' => [
           $customField->get()
        ]], $lead->get());
    }
}