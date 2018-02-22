<?php

namespace linkprofit\AmoCRM\tests\providers;


class CompanyProvider
{
    public function getCompany()
    {
        $company = new \linkprofit\AmoCRM\entities\Company();
        $company->responsible_user_id = 1924000;
        $company->name = 'Компания «Рога и копыта»';

        return $company;
    }
}