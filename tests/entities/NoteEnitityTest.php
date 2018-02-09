<?php

use PHPUnit\Framework\TestCase;

class NoteEntityTest extends TestCase
{
    public function testGet()
    {
        $note = $this->noteProvider();
        $this->assertEquals(['text' => 'Заметка', 'responsible_user_id' => 1924000, 'note_type' => 4], $note->get());
    }

    public function testSet()
    {
        $note = $this->noteProvider();
        $clonedNote = new \linkprofit\AmoCRM\entities\Note();
        $clonedNote->set($note->get());

        $this->assertTrue($note == $clonedNote);
    }

    public function testLinkContact()
    {
        $note = $this->noteProvider();

        $contact = $this->contactProvider();

        $this->assertTrue($note->linkElement($contact));
        $this->assertEquals(['text' => 'Заметка', 'responsible_user_id' => 1924000, 'note_type' => 4, 'element_type' => 1, 'element_id' => $contact->id], $note->get());
    }

    public function testLinkTask()
    {
        $note = $this->noteProvider();
        $task = $this->taskProvider();

        $this->assertTrue($note->linkElement($task));
        $this->assertEquals(['text' => 'Заметка', 'responsible_user_id' => 1924000, 'note_type' => 13, 'element_type' => 4, 'element_id' => $task->id], $note->get());
    }

    public function testLinkLead()
    {
        $note = $this->noteProvider();
        $lead = $this->leadProvider();

        $this->assertTrue($note->linkElement($lead));
        $this->assertEquals(['text' => 'Заметка', 'responsible_user_id' => 1924000, 'note_type' => 4, 'element_type' => 2, 'element_id' => $lead->id], $note->get());
    }

    public function testLinkCustomFieldError()
    {
        $note = $this->noteProvider();

        $customField = $this->customFieldProvider();

        $this->assertFalse($note->linkElement($customField));
    }

    public function testLinkElementWithoutIdError()
    {
        $note = $this->noteProvider();

        $lead = new \linkprofit\AmoCRM\entities\Lead();
        $this->assertFalse($note->linkElement($lead));

        $contact = new \linkprofit\AmoCRM\entities\Contact();
        $this->assertFalse($note->linkElement($contact));
    }

    protected function noteProvider()
    {
        $note = new \linkprofit\AmoCRM\entities\Note();
        $note->text = 'Заметка';
        $note->note_type = $note::COMMON;
        $note->responsible_user_id = 1924000;

        return $note;
    }

    protected function contactProvider()
    {
        $contact = new \linkprofit\AmoCRM\entities\Contact();
        $contact->id = 23;

        return $contact;
    }

    protected function taskProvider()
    {
        $task = new \linkprofit\AmoCRM\entities\Task();
        $task->id = 32;

        return $task;
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