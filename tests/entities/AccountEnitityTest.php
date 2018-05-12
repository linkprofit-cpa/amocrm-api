<?php

namespace linkprofit\AmoCRM\tests\entities;

use linkprofit\AmoCRM\entities\Account;
use linkprofit\AmoCRM\tests\providers\AccountProvider;
use PHPUnit\Framework\TestCase;


class AccountEnitityTest extends TestCase
{
    /**
     * @var AccountProvider
     */
    protected $account;

    public function testGet()
    {
        $company = $this->account->getAccount();
        $this->assertEquals([
            'id' => 1,
            'name' => 'Компания «Рога и копыта»',
            'subdomain' => 'domain',
            'currency' => 'RUB',
            'timezone' => 'Europe/Moscow',
            'language' => 'ru',
            'timezone_offset' => '+03:00',
            'current_user' => 1213232
        ], $company->get());
    }

    public function testSet()
    {
        $company = new Account();
        $data = [
            'id' => 1,
            'name' => 'Компания «Рога и копыта»',
            'subdomain' => 'domain',
            'currency' => 'RUB',
            'timezone' => 'Europe/Moscow',
            'language' => 'ru',
            'timezone_offset' => '+03:00',
            'current_user' => 23123123
        ];
        $company->set($data);

        $this->assertEquals($data, $company->get());
    }

    protected function setUp()
    {
        $this->account = new AccountProvider();
    }
}