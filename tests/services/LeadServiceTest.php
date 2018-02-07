<?php

use PHPUnit\Framework\TestCase;

class LeadServiceTest extends TestCase
{
    protected $emailField;
    protected $request;

    public function testAddLead()
    {
        $url = 'https://domain.amocrm.ru/api/v2/leads';
        $this->request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [['status_id' => '17077744', 'price' => 0, 'responsible_user_id' => 1924000, 'custom_fields' => [
                ['id' => '146785', 'name' => 'email', 'code' => 'EMAIL', 'values' => [['value' => 'email@email.com', 'enum' => '304683']]]
            ]]]]);

        $this->request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]]));

        $lead = new \linkprofit\AmoCRM\entities\Lead();
        $lead->status_id = 17077744;
        $lead->price = 0;
        $lead->responsible_user_id = 1924000;

        $lead->addCustomField($this->emailField);
        $leadService = new \linkprofit\AmoCRM\services\LeadService($this->request);
        $leadService->add($lead);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]], $leadService->createLead());

        $leads = $leadService->parseResponseToLeads();

        $this->assertEquals(1, $leads[0]->id);
    }

    public function testAddLeadError()
    {
        $url = 'https://domain.amocrm.ru/api/v2/leads';
        $this->request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [['status_id' => '17077744', 'price' => 0, 'responsible_user_id' => 1924000, 'custom_fields' => [
                ['id' => '146785', 'name' => 'email', 'code' => 'EMAIL', 'values' => [['value' => 'email@email.com', 'enum' => '304683']]]
            ]]]]);

        $this->request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => []]]));

        $lead = new \linkprofit\AmoCRM\entities\Lead();
        $lead->status_id = 17077744;
        $lead->price = 0;
        $lead->responsible_user_id = 1924000;

        $lead->addCustomField($this->emailField);
        $leadService = new \linkprofit\AmoCRM\services\LeadService($this->request);
        $leadService->add($lead);

        $this->assertFalse($leadService->createLead());
    }

    public function testAddLeads()
    {
        $url = 'https://domain.amocrm.ru/api/v2/leads';
        $this->request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [['status_id' => '17077744', 'price' => 0, 'responsible_user_id' => 1924000, 'custom_fields' => [
                ['id' => '146785', 'name' => 'email', 'code' => 'EMAIL', 'values' => [['value' => 'email@email.com', 'enum' => '304683']]]
            ]], ['status_id' => '17077744', 'price' => 300, 'responsible_user_id' => 1924000, 'custom_fields' => [
                ['id' => '146785', 'name' => 'email', 'code' => 'EMAIL', 'values' => [['value' => 'email@email.com', 'enum' => '304683']]]
            ]]]]);

        $this->request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1], ['id' => 2]]]]));

        $lead = new \linkprofit\AmoCRM\entities\Lead();
        $lead->status_id = 17077744;
        $lead->price = 0;
        $lead->responsible_user_id = 1924000;

        $lead->addCustomField($this->emailField);

        $secondLead = new \linkprofit\AmoCRM\entities\Lead();
        $secondLead->status_id = 17077744;
        $secondLead->price = 300;
        $secondLead->responsible_user_id = 1924000;

        $secondLead->addCustomField($this->emailField);

        $leadService = new \linkprofit\AmoCRM\services\LeadService($this->request);
        $leadService->add($lead);
        $leadService->add($secondLead);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1], ['id' => 2]]]], $leadService->createLead());

        $leads = $leadService->parseResponseToLeads();

        $this->assertEquals(1, $leads[0]->id);
        $this->assertEquals(2, $leads[1]->id);
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