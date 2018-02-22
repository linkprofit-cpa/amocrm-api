<?php

namespace linkprofit\AmoCRM\tests\services;

use linkprofit\AmoCRM\tests\providers\CompanyProvider;
use linkprofit\AmoCRM\tests\providers\CustomFieldProvider;
use PHPUnit\Framework\TestCase;
use linkprofit\AmoCRM\tests\providers\RequestProvider;

class CompanyServiceTest extends TestCase
{
    /**
     * @var CustomFieldProvider
     */
    protected $customField;

    /**
     * @var CompanyProvider
     */
    protected $company;

    /**
     * @var RequestProvider
     */
    protected $request;

    public function testAdd()
    {
        $company = $this->company->getCompany();
        $url = 'https://domain.amocrm.ru/api/v2/companies';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]]));

        $company->addCustomField($this->customField->getEmailField());

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$company->get()]]);

        $companyService = new \linkprofit\AmoCRM\services\CompanyService($request);
        $companyService->add($company);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]], $companyService->save());

        $companyService->parseResponseToEntities();
        $companies = $companyService->getEntities();

        $this->assertEquals(1, $companies[0]->id);
    }

    public function testUpdate()
    {
        $company = $this->company->getCompany();
        $url = 'https://domain.amocrm.ru/api/v2/companies';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 2]]]]));

        $company->addCustomField($this->customField->getEmailField());
        $company->id = 2;

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['update' => [$company->get()]]);

        $companyService = new \linkprofit\AmoCRM\services\CompanyService($request);
        $companyService->add($company);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 2]]]], $companyService->save());

        $companyService->parseResponseToEntities();
        $companies = $companyService->getEntities();

        $this->assertEquals(2, $companies[0]->id);
    }

    public function testAddError()
    {
        $url = 'https://domain.amocrm.ru/api/v2/companies';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => []]]));

        $company = $this->company->getCompany();

        $company->addCustomField($this->customField->getEmailField());

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$company->get()]]);

        $companyService = new \linkprofit\AmoCRM\services\CompanyService($request);
        $companyService->add($company);

        $this->assertFalse($companyService->save());
        $this->assertFalse($companyService->parseResponseToEntities());
    }

    public function testAddPlural()
    {
        $url = 'https://domain.amocrm.ru/api/v2/companies';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1], ['id' => 2]]]]));

        $company = $this->company->getCompany();

        $company->addCustomField($this->customField->getEmailField());

        $secondCompany = $this->company->getCompany();
        $secondCompany->name = 'Компания #2';

        $secondCompany->addCustomField($this->customField->getEmailField());

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$company->get(), $secondCompany->get()]]);

        $companyService = new \linkprofit\AmoCRM\services\CompanyService($request);
        $companyService->add($company);
        $companyService->add($secondCompany);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1], ['id' => 2]]]], $companyService->save());

        $companies = $companyService->parseResponseToEntities();

        $this->assertEquals(1, $companies[0]->id);
        $this->assertEquals(2, $companies[1]->id);
    }

    public function testParseArrayToEntity()
    {
        $company = $this->company->getCompany();
        $contactService = new \linkprofit\AmoCRM\services\CompanyService($this->request->getMockedRequest());

        $clonedCompany = $contactService->parseArrayToEntity($company->get());
        $this->assertTrue($company == $clonedCompany);
    }

    protected function setUp()
    {
        $this->customField = new CustomFieldProvider();
        $this->company = new CompanyProvider();
        $this->request = new RequestProvider();
    }
}