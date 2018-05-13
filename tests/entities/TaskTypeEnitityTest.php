<?php

namespace linkprofit\AmoCRM\tests\entities;

use linkprofit\AmoCRM\tests\providers\TaskTypeProvider;
use PHPUnit\Framework\TestCase;


class TaskTypeEnitityTest extends TestCase
{
    /**
     * @var TaskTypeProvider
     */
    protected $taskType;

    public function testGet()
    {
        $taskType = $this->taskType->getTaskType();
        $this->assertEquals(['name' => 'Тип задачи'], $taskType->get());
    }

    public function testGetWithId()
    {
        $taskType = $this->taskType->getTaskType();
        $taskType->id = 2;
        $taskArray = $taskType->get();
        $this->assertEquals(['id' => 2, 'name' => 'Тип задачи'], $taskArray);
    }

    protected function setUp()
    {
       $this->taskType = new TaskTypeProvider();
    }
}