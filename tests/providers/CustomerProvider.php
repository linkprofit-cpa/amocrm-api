<?php

namespace linkprofit\AmoCRM\tests\providers;


class CustomerProvider
{
    public function getCustomer()
    {
        $customer = new \linkprofit\AmoCRM\entities\Customer();
        $customer->created_by = 1924000;
        $customer->responsible_user_id = 1924000;
        $customer->name = 'Новый покупатель';

        return $customer;
    }
}