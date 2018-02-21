<?php

use PHPUnit\Framework\TestCase;

class CompanyServiceTest extends TestCase
{
    protected $emailField;
    protected $request;

    public function testAdd()
    {
        $company = $this->companyProvider();
        $url = 'https://domain.amocrm.ru/api/v2/companies';

        $this->request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]]));

        $company->addCustomField($this->emailField);

        $this->request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$company->get()]]);

        $companyService = new \linkprofit\AmoCRM\services\CompanyService($this->request);
        $companyService->add($company);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]], $companyService->save());

        $companyService->parseResponseToEntities();
        $companies = $companyService->getEntities();

        $this->assertEquals(1, $companies[0]->id);
    }

    public function testAddError()
    {
        $url = 'https://domain.amocrm.ru/api/v2/companies';

        $this->request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => []]]));

        $company = $this->companyProvider();

        $company->addCustomField($this->emailField);

        $this->request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$company->get()]]);

        $companyService = new \linkprofit\AmoCRM\services\CompanyService($this->request);
        $companyService->add($company);

        $this->assertFalse($companyService->save());
        $this->assertFalse($companyService->parseResponseToEntities());
    }

    public function testAddPlural()
    {
        $url = 'https://domain.amocrm.ru/api/v2/companies';

        $this->request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1], ['id' => 2]]]]));

        $company = $this->companyProvider();

        $company->addCustomField($this->emailField);

        $secondCompany = $this->companyProvider();
        $secondCompany->name = 'Компания #2';

        $secondCompany->addCustomField($this->emailField);

        $this->request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$company->get(), $secondCompany->get()]]);

        $companyService = new \linkprofit\AmoCRM\services\CompanyService($this->request);
        $companyService->add($company);
        $companyService->add($secondCompany);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1], ['id' => 2]]]], $companyService->save());

        $companies = $companyService->parseResponseToEntities();

        $this->assertEquals(1, $companies[0]->id);
        $this->assertEquals(2, $companies[1]->id);
    }

    public function testParseArrayToEntity()
    {
        $contact = $this->companyProvider();
        $contactService = new \linkprofit\AmoCRM\services\CompanyService($this->requestProvider());

        $clonedContact = $contactService->parseArrayToEntity($contact->get());
        $this->assertTrue($contact == $clonedContact);
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

    protected function companyProvider()
    {
        $contact = new \linkprofit\AmoCRM\entities\Company();
        $contact->responsible_user_id = 1924000;
        $contact->name = 'Компания';

        return $contact;
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