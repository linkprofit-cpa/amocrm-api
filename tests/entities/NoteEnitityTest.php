<?php

namespace linkprofit\AmoCRM\tests\entities;

use PHPUnit\Framework\TestCase;
use linkprofit\AmoCRM\tests\providers\NoteProvider;

class NoteEntityTest extends TestCase
{
    /**
     * @var NoteProvider
     */
    protected $note;

    public function testGet()
    {
        $note = $this->note->getNote();
        $this->assertEquals(['text' => 'Заметка', 'responsible_user_id' => 1924000, 'note_type' => 4], $note->get());
    }

    public function testGetWithId()
    {
        $note = $this->note->getNote();
        $note->id = 2;
        $noteArray = $note->get();
        $this->assertEquals(['id' => 2, 'text' => 'Заметка', 'responsible_user_id' => 1924000, 'note_type' => 4, 'updated_at' => $note->updated_at], $noteArray);
    }
    
    public function testGetWithParamArray() 
    {
        $note = $this->note->getNote();
        $note->params = ['text' => 'Текст системного сообщения'];
        $noteArray = $note->get();
        $this->assertEquals(['text' => 'Заметка', 'responsible_user_id' => 1924000, 'note_type' => 4, 'params' => ['text' => 'Текст системного сообщения']], $noteArray);
    }

    public function testSet()
    {
        $note = $this->note->getNote();

        $clonedNote = new \linkprofit\AmoCRM\entities\Note();
        $clonedNote->set($note->get());

        $this->assertTrue($note == $clonedNote);
    }

    public function testLinkContact()
    {
        $note = $this->note->getNote();

        $contact = $this->contactProvider();

        $this->assertTrue($note->linkElement($contact));
        $this->assertEquals(['text' => 'Заметка', 'responsible_user_id' => 1924000, 'note_type' => 4, 'element_type' => 1, 'element_id' => $contact->id], $note->get());
    }

    public function testLinkTask()
    {
        $note = $this->note->getNote();
        $task = $this->taskProvider();

        $this->assertTrue($note->linkElement($task));
        $this->assertEquals(['text' => 'Заметка', 'responsible_user_id' => 1924000, 'note_type' => 13, 'element_type' => 4, 'element_id' => $task->id], $note->get());
    }

    public function testLinkLead()
    {
        $note = $this->note->getNote();
        $lead = $this->leadProvider();

        $this->assertTrue($note->linkElement($lead));
        $this->assertEquals(['text' => 'Заметка', 'responsible_user_id' => 1924000, 'note_type' => 4, 'element_type' => 2, 'element_id' => $lead->id], $note->get());
    }

    public function testLinkNoteError()
    {
        $note = $this->note->getNote();

        $noteTolink = $this->note->getNote();
        $noteTolink->id = 1;

        $this->assertFalse($note->linkElement($noteTolink));
    }

    public function testLinkElementWithoutIdError()
    {
        $note = $this->note->getNote();

        $lead = new \linkprofit\AmoCRM\entities\Lead();
        $this->assertFalse($note->linkElement($lead));

        $contact = new \linkprofit\AmoCRM\entities\Contact();
        $this->assertFalse($note->linkElement($contact));
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

    protected function setUp()
    {
        $this->note = new NoteProvider();
    }
}