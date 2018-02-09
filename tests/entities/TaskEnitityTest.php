<?php

use PHPUnit\Framework\TestCase;

class TaskEntityTest extends TestCase
{
    public function testGet()
    {
        $task = $this->taskProvider();

        $this->assertEquals(['text' => 'Задача', 'complete_till_at' => $task->complete_till_at, 'responsible_user_id' => 1924000, 'task_type' => 1], $task->get());
    }
    public function testLinkContact()
    {
        $task = $this->taskProvider();

        $contact = $this->contactProvider();

        $this->assertTrue($task->linkElement($contact));
        $this->assertEquals(['text' => 'Задача', 'complete_till_at' => $task->complete_till_at, 'responsible_user_id' => 1924000, 'task_type' => 1, 'element_type' => 1, 'element_id' => $contact->id], $task->get());
    }

    public function testLinkLead()
    {
        $task = $this->taskProvider();

        $lead = $this->leadProvider();

        $this->assertTrue($task->linkElement($lead));
        $this->assertEquals(['text' => 'Задача', 'complete_till_at' => $task->complete_till_at, 'responsible_user_id' => 1924000, 'task_type' => 1, 'element_type' => 2, 'element_id' => $lead->id], $task->get());
    }

    public function testLinkCustomFieldError()
    {
        $task = $this->taskProvider();

        $customField = $this->customFieldProvider();

        $this->assertFalse($task->linkElement($customField));
    }

    public function testLinkElementWithoutIdError()
    {
        $task = $this->taskProvider();

        $lead = new \linkprofit\AmoCRM\entities\Lead();
        $this->assertFalse($task->linkElement($lead));

        $contact = new \linkprofit\AmoCRM\entities\Contact();
        $this->assertFalse($task->linkElement($contact));
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

    protected function customFieldProvider()
    {
        $customField = new \linkprofit\AmoCRM\entities\CustomField('146785', 'email', 'EMAIL');

        return $customField;
    }
}