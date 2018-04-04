<?php

namespace linkprofit\AmoCRM\tests\services;

use linkprofit\AmoCRM\tests\providers\CustomFieldProvider;
use linkprofit\AmoCRM\tests\providers\LeadProvider;
use linkprofit\AmoCRM\tests\providers\RequestProvider;
use PHPUnit\Framework\TestCase;

class LeadServiceTest extends TestCase
{
    /**
     * @var CustomFieldProvider
     */
    protected $customField;

    /**
     * @var LeadProvider
     */
    protected $lead;

    /**
     * @var RequestProvider
     */
    protected $request;

    public function testAdd()
    {
        $url = 'https://domain.amocrm.ru/api/v2/leads';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]]));

        $lead = $this->lead->getLead();

        $lead->addCustomField($this->customField->getEmailField());

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$lead->get()]]);

        $leadService = new \linkprofit\AmoCRM\services\LeadService($request);
        $leadService->add($lead);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]], $leadService->save());

        $leadService->parseResponseToEntities();
        $leads = $leadService->getEntities();

        $this->assertEquals(1, $leads[0]->id);
    }

    public function testUpdate()
    {
        $url = 'https://domain.amocrm.ru/api/v2/leads';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 2]]]]));

        $lead = $this->lead->getLead();
        $lead->id = 2;

        $lead->addCustomField($this->customField->getEmailField());

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['update' => [$lead->get()]]);

        $leadService = new \linkprofit\AmoCRM\services\LeadService($request);
        $leadService->add($lead);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 2]]]], $leadService->save());

        $leadService->parseResponseToEntities();
        $leads = $leadService->getEntities();

        $this->assertEquals(2, $leads[0]->id);
    }

    public function testAddError()
    {
        $url = 'https://domain.amocrm.ru/api/v2/leads';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => []]]));

        $lead = $this->lead->getLead();

        $lead->addCustomField($this->customField->getEmailField());

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$lead->get()]]);

        $leadService = new \linkprofit\AmoCRM\services\LeadService($request);
        $leadService->add($lead);

        $this->assertFalse($leadService->save());
        $this->assertFalse($leadService->parseResponseToEntities());
    }

    public function testAddPlural()
    {
        $url = 'https://domain.amocrm.ru/api/v2/leads';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1], ['id' => 2]]]]));

        $lead = $this->lead->getLead();

        $lead->addCustomField($this->customField->getEmailField());

        $secondLead = $this->lead->getLead();
        $secondLead->sale = 300;

        $secondLead->addCustomField($this->customField->getEmailField());

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$lead->get(), $secondLead->get()]]);

        $leadService = new \linkprofit\AmoCRM\services\LeadService($request);
        $leadService->add($lead);
        $leadService->add($secondLead);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1], ['id' => 2]]]], $leadService->save());

        $leads = $leadService->parseResponseToEntities();

        $this->assertEquals(1, $leads[0]->id);
        $this->assertEquals(2, $leads[1]->id);
    }

    public function testParseArrayToEntity()
    {
        $lead = $this->lead->getLead();
        $leadService = new \linkprofit\AmoCRM\services\LeadService($this->request->getMockedRequest());

        $clonedLead = $leadService->parseArrayToEntity($lead->get());
        $this->assertTrue($lead == $clonedLead);
    }

    protected function setUp()
    {
        $this->customField = new CustomFieldProvider();
        $this->request = new RequestProvider();
        $this->lead = new LeadProvider();
    }

}