<?php

use PHPUnit\Framework\TestCase;

class TaskServiceTest extends TestCase
{
    protected $request;
    protected $task;

    public function testAdd()
    {
        $url = 'https://domain.amocrm.ru/api/v2/tasks';

        $this->request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($this->responseProvider()));


        $this->request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$this->task->get()]]);

        $taskService = new \linkprofit\AmoCRM\services\TaskService($this->request);
        $taskService->add($this->task);

        $this->assertEquals($this->responseProvider(), $taskService->create());

        $taskService->parseResponseToEntities();
        $tasks = $taskService->getEntities();

        $this->assertEquals(1, $tasks[0]->id);
    }

    public function testAddError()
    {
        $url = 'https://domain.amocrm.ru/api/v2/tasks';

        $this->request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => []]]));

        $this->request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$this->task->get()]]);


        $taskService = new \linkprofit\AmoCRM\services\TaskService($this->request);
        $taskService->add($this->task);

        $this->assertFalse($taskService->create());
        $this->assertFalse($taskService->parseResponseToEntities());
    }

    public function testParseArrayToEntity()
    {
        $task = $this->taskProvider();
        $taskService = new \linkprofit\AmoCRM\services\TaskService($this->requestProvider());

        $clonedTask = $taskService->parseArrayToEntity($task->get());
        $this->assertTrue($task == $clonedTask);
    }

    protected function setUp()
    {
        $this->request = $this->requestProvider();
        $this->task = $this->taskProvider();
    }

    protected function responseProvider()
    {
        return ['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]];
    }

    protected function taskProvider()
    {
        $task = new \linkprofit\AmoCRM\entities\Task();
        $task->text = 'Задача';

        $nextDayTimestamp = strtotime('+1 day');
        $task->complete_till_at = $nextDayTimestamp;

        $task->task_type = $task::CALL_TASK_TYPE;
        $task->responsible_user_id = 1924000;

        return $task;
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