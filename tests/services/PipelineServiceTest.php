<?php

use PHPUnit\Framework\TestCase;

class PipelineServiceTest extends TestCase
{
    protected $request;

    public function testAdd()
    {
        $url = 'https://domain.amocrm.ru/private/api/v2/json/pipelines/set';

        $this->request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]]));

        $pipeline = $this->pipelineProvider();

        $pipeline->addStatus($this->statusProvider());

        $this->request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$pipeline->get()]]);

        $pipelineService = new \linkprofit\AmoCRM\services\PipelineService($this->request);
        $pipelineService->add($pipeline);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]], $pipelineService->save());

        $pipelineService->parseResponseToEntities();
        $pipelines = $pipelineService->getEntities();

        $this->assertEquals(1, $pipelines[0]->id);
    }

    public function testAddError()
    {
        $url = 'https://domain.amocrm.ru/private/api/v2/json/pipelines/set';

        $this->request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => []]]));

        $pipeline = $this->pipelineProvider();

        $pipeline->addStatus($this->statusProvider());

        $this->request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$pipeline->get()]]);

        $pipelineService = new \linkprofit\AmoCRM\services\PipelineService($this->request);
        $pipelineService->add($pipeline);

        $this->assertFalse($pipelineService->save());
        $this->assertFalse($pipelineService->parseResponseToEntities());
    }

    public function testAddPlural()
    {
        $url = 'https://domain.amocrm.ru/private/api/v2/json/pipelines/set';

        $this->request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1], ['id' => 2]]]]));

        $pipeline = $this->pipelineProvider();

        $pipeline->addStatus($this->statusProvider());

        $secondPipeline = $this->pipelineProvider();
        $secondPipeline->sale = 300;

        $pipeline->addStatus($this->statusProvider());

        $this->request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$pipeline->get(), $secondPipeline->get()]]);

        $pipelineService = new \linkprofit\AmoCRM\services\PipelineService($this->request);
        $pipelineService->add($pipeline);
        $pipelineService->add($secondPipeline);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1], ['id' => 2]]]], $pipelineService->save());

        $pipelines = $pipelineService->parseResponseToEntities();

        $this->assertEquals(1, $pipelines[0]->id);
        $this->assertEquals(2, $pipelines[1]->id);
    }

    public function testParseArrayToEntity()
    {
        $pipeline = $this->pipelineProvider();
        $leadService = new \linkprofit\AmoCRM\services\PipelineService($this->requestProvider());

        $clonedPipeline = $leadService->parseArrayToEntity($pipeline->get());
        $this->assertTrue($pipeline == $clonedPipeline);
    }

    protected function setUp()
    {
        $this->request = $this->requestProvider();
    }

    protected function pipelineProvider()
    {
        $pipeline = new \linkprofit\AmoCRM\entities\Pipeline();
        $pipeline->name = 'Воронка';
        $pipeline->sort = 2;
        $pipeline->is_main = 'on';

        return $pipeline;
    }

    protected function statusProvider()
    {
        $status = new \linkprofit\AmoCRM\entities\Status();
        $status->name = 'Статус';
        $status->sort = 1;
        $status->color = '#fffeb2';

        return $status;
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