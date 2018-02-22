<?php

namespace linkprofit\AmoCRM\tests\providers;


class LeadProvider
{
    public function getLead()
    {
        $lead = new \linkprofit\AmoCRM\entities\Lead();
        $lead->status_id = 17077744;
        $lead->sale = 0;
        $lead->responsible_user_id = 1924000;

        return $lead;
    }
}