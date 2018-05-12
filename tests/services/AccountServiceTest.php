<?php

namespace linkprofit\AmoCRM\tests\services;

use linkprofit\AmoCRM\tests\providers\AccountProvider;
use PHPUnit\Framework\TestCase;
use linkprofit\AmoCRM\tests\providers\RequestProvider;

class AccountServiceTest extends TestCase
{
    /**
     * @var AccountProvider
     */
    protected $account;

    /**
     * @var RequestProvider
     */
    protected $request;

    public function testGetAllArray()
    {
        $request = $this->request->getMockedRequest();

        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['users' => [['id' => 1]]]]));

        $accountService = new \linkprofit\AmoCRM\services\AccountService($request);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['users' => [['id' => 1]]]], $accountService->getAllArray());
    }

    public function testGetAccount()
    {
        $account = $this->account->getAccount();

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($account->get()));

        $accountService = new \linkprofit\AmoCRM\services\AccountService($request);

        $this->assertEquals($account, $accountService->getAccount());
    }

    public function testGetTaskTypes()
    {
        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_embedded' => ['task_types' => [['id' => 1]]]]));

        $accountService = new \linkprofit\AmoCRM\services\AccountService($request);

        $this->assertEquals(1, $accountService->getTaskTypes()[0]->id);
    }

    protected function setUp()
    {
        $this->account = new AccountProvider();
        $this->request = new RequestProvider();
    }
}