<?php

namespace linkprofit\AmoCRM\tests\providers;


class AccountProvider
{
    public function getAccount()
    {
        $account = new \linkprofit\AmoCRM\entities\Account();
        $account->id = 1;
        $account->name = 'Компания «Рога и копыта»';
        $account->current_user = 1213232;
        $account->currency = 'RUB';
        $account->language = 'ru';
        $account->subdomain = 'domain';
        $account->timezone = 'Europe/Moscow';
        $account->timezone_offset = '+03:00';

        return $account;
    }
}