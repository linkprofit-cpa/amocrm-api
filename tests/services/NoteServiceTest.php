<?php

namespace linkprofit\AmoCRM\tests\services;

use linkprofit\AmoCRM\tests\providers\CustomFieldProvider;
use linkprofit\AmoCRM\tests\providers\NoteProvider;
use linkprofit\AmoCRM\tests\providers\RequestProvider;
use PHPUnit\Framework\TestCase;

class NoteServiceTest extends TestCase
{
    /**
     * @var CustomFieldProvider
     */
    protected $customField;

    /**
     * @var NoteProvider
     */
    protected $note;

    /**
     * @var RequestProvider
     */
    protected $request;

    public function testAdd()
    {
        $url = 'https://domain.amocrm.ru/api/v2/notes';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($this->responseProvider()));

        $note = $this->note->getNote();
        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$note->get()]]);

        $noteService = new \linkprofit\AmoCRM\services\NoteService($request);
        $noteService->add($note);

        $this->assertEquals($this->responseProvider(), $noteService->save());

        $noteService->parseResponseToEntities();
        $notes = $noteService->getEntities();

        $this->assertEquals(1, $notes[0]->id);
    }

    public function testUpdate()
    {
        $url = 'https://domain.amocrm.ru/api/v2/notes';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($this->responseProvider()));

        $note = $this->note->getNote();
        $note->id = 1;
        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['update' => [$note->get()]]);

        $noteService = new \linkprofit\AmoCRM\services\NoteService($request);
        $noteService->add($note);

        $this->assertEquals($this->responseProvider(), $noteService->save());

        $noteService->parseResponseToEntities();
        $notes = $noteService->getEntities();

        $this->assertEquals(1, $notes[0]->id);
    }

    public function testAddError()
    {
        $url = 'https://domain.amocrm.ru/api/v2/notes';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => []]]));

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$this->note->getNote()->get()]]);

        $noteService = new \linkprofit\AmoCRM\services\NoteService($request);
        $noteService->add($this->note->getNote());

        $this->assertFalse($noteService->save());
        $this->assertFalse($noteService->parseResponseToEntities());
    }

    public function testParseArrayToEntity()
    {
        $note = $this->note->getNote();
        $noteService = new \linkprofit\AmoCRM\services\NoteService($this->request->getMockedRequest());

        $clonedNote = $noteService->parseArrayToEntity($note->get());
        $this->assertTrue($note == $clonedNote);
    }

    protected function setUp()
    {
        $this->customField = new CustomFieldProvider();
        $this->request = new RequestProvider();
        $this->note = new NoteProvider();
    }

    protected function responseProvider()
    {
        return ['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]];
    }
}