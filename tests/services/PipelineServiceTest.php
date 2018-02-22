<?php

namespace linkprofit\AmoCRM\tests\services;

use linkprofit\AmoCRM\tests\providers\CustomFieldProvider;
use linkprofit\AmoCRM\tests\providers\PipelineProvider;
use linkprofit\AmoCRM\tests\providers\RequestProvider;
use linkprofit\AmoCRM\tests\providers\StatusProvider;
use PHPUnit\Framework\TestCase;

class PipelineServiceTest extends TestCase
{
    /**
     * @var PipelineProvider
     */
    protected $pipeline;

    /**
     * @var StatusProvider
     */
    protected $pipelineStatus;
    /**
     * @var RequestProvider
     */
    protected $request;


    public function testAdd()
    {
        $url = 'https://domain.amocrm.ru/private/api/v2/json/pipelines/set';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]]));

        $pipeline = $this->pipeline->getPipeline();

        $pipeline->addStatus($this->pipelineStatus->getStatus());

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$pipeline->get()]]);

        $pipelineService = new \linkprofit\AmoCRM\services\PipelineService($request);
        $pipelineService->add($pipeline);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]], $pipelineService->save());

        $pipelineService->parseResponseToEntities();
        $pipelines = $pipelineService->getEntities();

        $this->assertEquals(1, $pipelines[0]->id);
    }

    public function testUpdate()
    {
        $url = 'https://domain.amocrm.ru/private/api/v2/json/pipelines/set';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 2]]]]));

        $pipeline = $this->pipeline->getPipeline();
        $pipeline->id = 2;

        $pipeline->addStatus($this->pipelineStatus->getStatus());

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['update' => [$pipeline->get()]]);

        $pipelineService = new \linkprofit\AmoCRM\services\PipelineService($request);
        $pipelineService->add($pipeline);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 2]]]], $pipelineService->save());

        $pipelineService->parseResponseToEntities();
        $pipelines = $pipelineService->getEntities();

        $this->assertEquals(2, $pipelines[0]->id);
    }

    public function testAddError()
    {
        $url = 'https://domain.amocrm.ru/private/api/v2/json/pipelines/set';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => []]]));

        $pipeline = $this->pipeline->getPipeline();

        $pipeline->addStatus($this->pipelineStatus->getStatus());

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$pipeline->get()]]);

        $pipelineService = new \linkprofit\AmoCRM\services\PipelineService($request);
        $pipelineService->add($pipeline);

        $this->assertFalse($pipelineService->save());
        $this->assertFalse($pipelineService->parseResponseToEntities());
    }

    public function testAddPlural()
    {
        $url = 'https://domain.amocrm.ru/private/api/v2/json/pipelines/set';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1], ['id' => 2]]]]));

        $pipeline = $this->pipeline->getPipeline();

        $pipeline->addStatus($this->pipelineStatus->getStatus());

        $secondPipeline = $this->pipeline->getPipeline();
        $secondPipeline->sale = 300;

        $pipeline->addStatus($this->pipelineStatus->getStatus());

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$pipeline->get(), $secondPipeline->get()]]);

        $pipelineService = new \linkprofit\AmoCRM\services\PipelineService($request);
        $pipelineService->add($pipeline);
        $pipelineService->add($secondPipeline);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1], ['id' => 2]]]], $pipelineService->save());

        $pipelines = $pipelineService->parseResponseToEntities();

        $this->assertEquals(1, $pipelines[0]->id);
        $this->assertEquals(2, $pipelines[1]->id);
    }

    public function testParseArrayToEntity()
    {
        $pipeline = $this->pipeline->getPipeline();
        $leadService = new \linkprofit\AmoCRM\services\PipelineService($this->request->getMockedRequest());

        $clonedPipeline = $leadService->parseArrayToEntity($pipeline->get());
        $this->assertTrue($pipeline == $clonedPipeline);
    }

    protected function setUp()
    {
        $this->request = new RequestProvider();
        $this->pipelineStatus = new StatusProvider();
        $this->pipeline = new PipelineProvider();
    }
}