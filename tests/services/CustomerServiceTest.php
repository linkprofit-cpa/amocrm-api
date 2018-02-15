<?php

use PHPUnit\Framework\TestCase;

class CustomerServiceTest extends TestCase
{
    protected $emailField;
    protected $request;

    public function testAdd()
    {
        $url = 'https://domain.amocrm.ru/api/v2/customers';

        $this->request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]]));

        $customer = $this->customerProvider();

        $customer->addCustomField($this->emailField);

        $this->request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$customer->get()]]);

        $customerService = new \linkprofit\AmoCRM\services\CustomerService($this->request);
        $customerService->add($customer);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]], $customerService->create());

        $customerService->parseResponseToEntities();
        $customers = $customerService->getEntities();

        $this->assertEquals(1, $customers[0]->id);
    }

    public function testAddError()
    {
        $url = 'https://domain.amocrm.ru/api/v2/customers';

        $this->request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => []]]));

        $customer = $this->customerProvider();

        $customer->addCustomField($this->emailField);

        $this->request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$customer->get()]]);

        $customerService = new \linkprofit\AmoCRM\services\CustomerService($this->request);
        $customerService->add($customer);

        $this->assertFalse($customerService->create());
        $this->assertFalse($customerService->parseResponseToEntities());
    }

    public function testAddPlural()
    {
        $url = 'https://domain.amocrm.ru/api/v2/customers';

        $this->request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1], ['id' => 2]]]]));

        $customer = $this->customerProvider();

        $customer->addCustomField($this->emailField);

        $secondCustomer = $this->customerProvider();
        $secondCustomer->sale = 300;

        $secondCustomer->addCustomField($this->emailField);

        $this->request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$customer->get(), $secondCustomer->get()]]);

        $customerService = new \linkprofit\AmoCRM\services\CustomerService($this->request);
        $customerService->add($customer);
        $customerService->add($secondCustomer);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1], ['id' => 2]]]], $customerService->create());

        $customers = $customerService->parseResponseToEntities();

        $this->assertEquals(1, $customers[0]->id);
        $this->assertEquals(2, $customers[1]->id);
    }

    public function testParseArrayToEntity()
    {
        $customer = $this->customerProvider();
        $customerService = new \linkprofit\AmoCRM\services\CustomerService($this->requestProvider());

        $clonedCustomer = $customerService->parseArrayToEntity($customer->get());
        $this->assertTrue($customer == $clonedCustomer);
    }

    protected function setUp()
    {
        $this->emailField = $this->emailFieldProvider();
        $this->request = $this->requestProvider();
    }

    protected function emailFieldProvider()
    {
        $emailField = new \linkprofit\AmoCRM\entities\CustomField('146785', 'email', 'EMAIL');
        $emailField->addValue(new \linkprofit\AmoCRM\entities\Value(
                'email@email.com', '304683'
            )
        );

        return $emailField;
    }

    protected function customerProvider()
    {
        $customer = new \linkprofit\AmoCRM\entities\Customer();
        $customer->created_by = 1924000;
        $customer->responsible_user_id = 1924000;
        $customer->name = 'Новый покупатель';

        return $customer;
    }

    protected function requestProvider()
    {
        $request = $this->getMockBuilder(\linkprofit\AmoCRM\RequestHandler::class)
            ->setMethods(['getSubdomain', 'performRequest', 'getResponse'])
            ->getMock();

        $request->method('getSubdomain')
            ->will($this->returnValue('domain'));

        return $request;
    }
}