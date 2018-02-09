<?php

use PHPUnit\Framework\TestCase;

class NoteServiceTest extends TestCase
{
    protected $request;
    protected $note;

    public function testAddNote()
    {
        $url = 'https://domain.amocrm.ru/api/v2/notes';

        $this->request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($this->responseProvider()));


        $this->request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$this->note->get()]]);

        $noteService = new \linkprofit\AmoCRM\services\NoteService($this->request);
        $noteService->add($this->note);

        $this->assertEquals($this->responseProvider(), $noteService->create());

        $noteService->parseResponseToEntities();
        $notes = $noteService->getEntities();

        $this->assertEquals(1, $notes[0]->id);
    }

    public function testAddNoteError()
    {
        $url = 'https://domain.amocrm.ru/api/v2/notes';

        $this->request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => []]]));

        $this->request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$this->note->get()]]);


        $noteService = new \linkprofit\AmoCRM\services\NoteService($this->request);
        $noteService->add($this->note);

        $this->assertFalse($noteService->create());
        $this->assertFalse($noteService->parseResponseToEntities());
    }

    public function testParseArrayToEntity()
    {
        $note = $this->noteProvider();
        $noteService = new \linkprofit\AmoCRM\services\NoteService($this->request);

        $clonedNote = $noteService->parseArrayToEntity($note->get());
        $this->assertTrue($note == $clonedNote);
    }

    protected function setUp()
    {
        $this->request = $this->requestProvider();
        $this->note = $this->noteProvider();
    }

    protected function responseProvider()
    {
        return ['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]];
    }

    protected function noteProvider()
    {
        $note = new \linkprofit\AmoCRM\entities\Note();
        $note->text = 'Заметка';
        $note->note_type = $note::COMMON;
        $note->responsible_user_id = 1924000;

        return $note;
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