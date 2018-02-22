<?php

namespace linkprofit\AmoCRM\tests\services;

use linkprofit\AmoCRM\tests\providers\CustomerProvider;
use PHPUnit\Framework\TestCase;
use linkprofit\AmoCRM\tests\providers\CustomFieldProvider;
use linkprofit\AmoCRM\tests\providers\RequestProvider;

class CustomerServiceTest extends TestCase
{
    /**
     * @var CustomFieldProvider
     */
    protected $customField;

    /**
     * @var CustomerProvider
     */
    protected $customer;

    /**
     * @var RequestProvider
     */
    protected $request;

    public function testAdd()
    {
        $url = 'https://domain.amocrm.ru/api/v2/customers';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]]));

        $customer = $this->customer->getCustomer();

        $customer->addCustomField($this->customField->getEmailField());

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$customer->get()]]);

        $customerService = new \linkprofit\AmoCRM\services\CustomerService($request);
        $customerService->add($customer);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]], $customerService->save());

        $customerService->parseResponseToEntities();
        $customers = $customerService->getEntities();

        $this->assertEquals(1, $customers[0]->id);
    }

    public function testUpdate()
    {
        $url = 'https://domain.amocrm.ru/api/v2/customers';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 2]]]]));

        $customer = $this->customer->getCustomer();
        $customer->id = 2;

        $customer->addCustomField($this->customField->getEmailField());

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['update' => [$customer->get()]]);

        $customerService = new \linkprofit\AmoCRM\services\CustomerService($request);
        $customerService->add($customer);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 2]]]], $customerService->save());

        $customerService->parseResponseToEntities();
        $customers = $customerService->getEntities();

        $this->assertEquals(2, $customers[0]->id);
    }

    public function testAddError()
    {
        $url = 'https://domain.amocrm.ru/api/v2/customers';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => []]]));

        $customer = $this->customer->getCustomer();

        $customer->addCustomField($this->customField->getEmailField());

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$customer->get()]]);

        $customerService = new \linkprofit\AmoCRM\services\CustomerService($request);
        $customerService->add($customer);

        $this->assertFalse($customerService->save());
        $this->assertFalse($customerService->parseResponseToEntities());
    }

    public function testAddPlural()
    {
        $url = 'https://domain.amocrm.ru/api/v2/customers';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1], ['id' => 2]]]]));

        $customer = $this->customer->getCustomer();
        $customer->addCustomField($this->customField->getEmailField());

        $secondCustomer = $this->customer->getCustomer();
        $secondCustomer->addCustomField($this->customField->getEmailField());

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$customer->get(), $secondCustomer->get()]]);

        $customerService = new \linkprofit\AmoCRM\services\CustomerService($request);
        $customerService->add($customer);
        $customerService->add($secondCustomer);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1], ['id' => 2]]]], $customerService->save());

        $customers = $customerService->parseResponseToEntities();

        $this->assertEquals(1, $customers[0]->id);
        $this->assertEquals(2, $customers[1]->id);
    }

    public function testParseArrayToEntity()
    {
        $customer = $this->customer->getCustomer();
        $customerService = new \linkprofit\AmoCRM\services\CustomerService($this->request->getMockedRequest());

        $clonedCustomer = $customerService->parseArrayToEntity($customer->get());
        $this->assertTrue($customer == $clonedCustomer);
    }

    protected function setUp()
    {
        $this->customField = new CustomFieldProvider();
        $this->request = new RequestProvider();
        $this->customer = new CustomerProvider();
    }
}