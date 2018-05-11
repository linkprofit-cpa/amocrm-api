<?php

namespace linkprofit\AmoCRM\tests\services;

use linkprofit\AmoCRM\entities\TaskType;
use linkprofit\AmoCRM\tests\providers\RequestProvider;
use linkprofit\AmoCRM\tests\providers\TaskTypeProvider;
use PHPUnit\Framework\TestCase;

class TaskTypeServiceTest extends TestCase
{
    /**
     * @var TaskTypeProvider
     */
    protected $taskType;
    /**
     * @var RequestProvider
     */
    protected $request;

    public function testAdd()
    {
        $url = 'https://domain.amocrm.ru/private/tasks/ajax_task_status_edit.php';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($this->responseProvider()));

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['ACTION' => 'ALL_EDIT', 'task_types' => [$this->taskType->getTaskType()->get()]], 'application/x-www-form-urlencoded');

        $taskTypeService = new \linkprofit\AmoCRM\services\TaskTypeService($request);
        $taskTypeService->add($this->taskType->getTaskType());

        $this->assertEquals($this->responseProvider(), $taskTypeService->save());

        $taskTypeService->parseResponseToEntities();
        $tasks = $taskTypeService->getEntities();

        $this->assertEquals(1, $tasks[0]->id);
    }

    public function testUpdate()
    {
        $url = 'https://domain.amocrm.ru/private/tasks/ajax_task_status_edit.php';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($this->responseProvider()));

        $taskType = $this->taskType->getTaskType();
        $taskType->id = 1;
        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['ACTION' => 'ALL_EDIT', 'task_types' => [$taskType->get()]], 'application/x-www-form-urlencoded');

        $taskService = new \linkprofit\AmoCRM\services\TaskTypeService($request);
        $taskService->add($taskType);

        $this->assertEquals($this->responseProvider(), $taskService->save());

        $taskService->parseResponseToEntities();
        $tasks = $taskService->getEntities();

        $this->assertEquals(1, $tasks[0]->id);
    }

    public function testAddError()
    {
        $url = 'https://domain.amocrm.ru/private/tasks/ajax_task_status_edit.php';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['status' => 'FAIL', 'data' => 'WRONG_ACTION']));

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['ACTION' => 'ALL_EDIT', 'task_types' => [$this->taskType->getTaskType()->get()]], 'application/x-www-form-urlencoded');


        $taskService = new \linkprofit\AmoCRM\services\TaskTypeService($request);
        $taskService->add($this->taskType->getTaskType());

        $this->assertFalse($taskService->save());
        $this->assertFalse($taskService->parseResponseToEntities());
    }

    public function testParseArrayToEntity()
    {
        $taskType = $this->taskType->getTaskType();
        $taskService = new \linkprofit\AmoCRM\services\TaskTypeService($this->request->getMockedRequest());

        $clonedTask = $taskService->parseArrayToEntity($taskType->get());
        $this->assertTrue($taskType == $clonedTask);
    }

    protected function setUp()
    {
        $this->request = new RequestProvider();
        $this->taskType = new TaskTypeProvider();
    }

    protected function responseProvider()
    {
        return [
            'status'     => 'OK',
            'data' => [
                'key' => ['id' => 1, 'name' => 'test']
            ],
        ];
    }
}