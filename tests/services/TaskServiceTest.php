<?php

namespace linkprofit\AmoCRM\tests\services;

use linkprofit\AmoCRM\tests\providers\RequestProvider;
use linkprofit\AmoCRM\tests\providers\TaskProvider;
use PHPUnit\Framework\TestCase;

class TaskServiceTest extends TestCase
{
    /**
     * @var TaskProvider
     */
    protected $task;
    /**
     * @var RequestProvider
     */
    protected $request;

    public function testAdd()
    {
        $url = 'https://domain.amocrm.ru/api/v2/tasks';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($this->responseProvider()));

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$this->task->getTask()->get()]]);

        $taskService = new \linkprofit\AmoCRM\services\TaskService($request);
        $taskService->add($this->task->getTask());

        $this->assertEquals($this->responseProvider(), $taskService->save());

        $taskService->parseResponseToEntities();
        $tasks = $taskService->getEntities();

        $this->assertEquals(1, $tasks[0]->id);
    }

    public function testUpdate()
    {
        $url = 'https://domain.amocrm.ru/api/v2/tasks';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($this->responseProvider()));

        $task = $this->task->getTask();
        $task->id = 1;
        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['update' => [$task->get()]]);

        $taskService = new \linkprofit\AmoCRM\services\TaskService($request);
        $taskService->add($task);

        $this->assertEquals($this->responseProvider(), $taskService->save());

        $taskService->parseResponseToEntities();
        $tasks = $taskService->getEntities();

        $this->assertEquals(1, $tasks[0]->id);
    }

    public function testAddError()
    {
        $url = 'https://domain.amocrm.ru/api/v2/tasks';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => []]]));

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$this->task->getTask()->get()]]);


        $taskService = new \linkprofit\AmoCRM\services\TaskService($request);
        $taskService->add($this->task->getTask());

        $this->assertFalse($taskService->save());
        $this->assertFalse($taskService->parseResponseToEntities());
    }

    public function testParseArrayToEntity()
    {
        $task = $this->task->getTask();
        $taskService = new \linkprofit\AmoCRM\services\TaskService($this->request->getMockedRequest());

        $clonedTask = $taskService->parseArrayToEntity($task->get());
        $this->assertTrue($task == $clonedTask);
    }

    protected function setUp()
    {
        $this->request = new RequestProvider();
        $this->task = new TaskProvider();
    }

    protected function responseProvider()
    {
        return ['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]];
    }
}