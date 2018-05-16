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

    public function testGetCustomFieldsTypes()
    {
        $request = $this->request->getMockedRequest();
        $responseData = [
            '_embedded' => [
                'custom_fields' => [
                    'contacts' => [
                        ['id'=>2]
                    ],
                    'leads' => [
                        ['id'=>3]
                    ],
                    'companies' => [
                        ['id'=>4]
                    ],
                    'customers' => [
                        ['id'=>5]
                    ],
                    'catalogs' => [
                        123 => [
                            ['id' => 345],
                            ['id' => 346]
                        ],
                        124 => [
                            ['id' => 347],
                            ['id' => 348]
                        ],
                    ],
                ],
            ],
        ];
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($responseData));

        $accountService = new \linkprofit\AmoCRM\services\AccountService($request);


        $fields = $accountService->getCustomFields();

        $this->assertEquals(2, $fields[0]->id);
        $this->assertEquals(1, $fields[0]->element_type);

        $this->assertEquals(3, $fields[1]->id);
        $this->assertEquals(2, $fields[1]->element_type);

        $this->assertEquals(4, $fields[2]->id);
        $this->assertEquals(3, $fields[2]->element_type);

        $this->assertEquals(5, $fields[3]->id);
        $this->assertEquals(12, $fields[3]->element_type);

        $this->assertEquals(5, $fields[3]->id);
        $this->assertEquals(12, $fields[3]->element_type);

        $this->assertEquals(345, $fields[4]->id);
        $this->assertEquals(123, $fields[4]->element_type);

        $this->assertEquals(346, $fields[5]->id);
        $this->assertEquals(123, $fields[5]->element_type);

        $this->assertEquals(347, $fields[6]->id);
        $this->assertEquals(124, $fields[6]->element_type);

        $this->assertEquals(348, $fields[7]->id);
        $this->assertEquals(124, $fields[7]->element_type);
    }

    protected function setUp()
    {
        $this->account = new AccountProvider();
        $this->request = new RequestProvider();
    }
}