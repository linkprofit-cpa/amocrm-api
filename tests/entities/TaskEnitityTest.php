<?php

namespace linkprofit\AmoCRM\tests\entities;

use PHPUnit\Framework\TestCase;
use linkprofit\AmoCRM\tests\providers\TaskProvider;


class TaskEntityTest extends TestCase
{
    /**
     * @var TaskProvider
     */
    protected $task;

    public function testGet()
    {
        $task = $this->task->getTask();
        $this->assertEquals(['text' => 'Задача', 'complete_till_at' => $task->complete_till_at, 'responsible_user_id' => 1924000, 'task_type' => 1], $task->get());
    }

    public function testGetWithId()
    {
        $task = $this->task->getTask();
        $task->id = 2;
        $taskArray = $task->get();
        $this->assertEquals(['id' => 2, 'text' => 'Задача', 'complete_till_at' => $task->complete_till_at, 'responsible_user_id' => 1924000, 'task_type' => 1, 'updated_at' => $task->updated_at], $taskArray);
    }

    public function testLinkContact()
    {
        $task = $this->task->getTask();

        $contact = $this->contactProvider();

        $this->assertTrue($task->linkElement($contact));
        $this->assertEquals(['text' => 'Задача', 'complete_till_at' => $task->complete_till_at, 'responsible_user_id' => 1924000, 'task_type' => 1, 'element_type' => 1, 'element_id' => $contact->id], $task->get());
    }

    public function testLinkLead()
    {
        $task = $this->task->getTask();

        $lead = $this->leadProvider();

        $this->assertTrue($task->linkElement($lead));
        $this->assertEquals(['text' => 'Задача', 'complete_till_at' => $task->complete_till_at, 'responsible_user_id' => 1924000, 'task_type' => 1, 'element_type' => 2, 'element_id' => $lead->id], $task->get());
    }

    public function testLinkError()
    {
        $task = $this->task->getTask();

        $taskToLink = $this->task->getTask();
        $taskToLink->id = 1;

        $this->assertFalse($task->linkElement($taskToLink));
    }

    public function testLinkElementWithoutIdError()
    {
        $task = $this->task->getTask();

        $lead = new \linkprofit\AmoCRM\entities\Lead();
        $this->assertFalse($task->linkElement($lead));

        $contact = new \linkprofit\AmoCRM\entities\Contact();
        $this->assertFalse($task->linkElement($contact));
    }

    protected function contactProvider()
    {
        $contact = new \linkprofit\AmoCRM\entities\Contact();
        $contact->id = 23;

        return $contact;
    }

    protected function leadProvider()
    {
        $lead = new \linkprofit\AmoCRM\entities\Lead();
        $lead->id = 32;

        return $lead;
    }

    protected function setUp()
    {
       $this->task = new TaskProvider();
    }
}