<?php

namespace linkprofit\AmoCRM\tests\services;

use PHPUnit\Framework\TestCase;
use linkprofit\AmoCRM\tests\providers\CustomFieldProvider;
use linkprofit\AmoCRM\tests\providers\ContactProvider;
use linkprofit\AmoCRM\tests\providers\RequestProvider;

class ContactServiceTest extends TestCase
{
    /**
     * @var CustomFieldProvider
     */
    protected $customField;

    /**
     * @var ContactProvider
     */
    protected $contact;

    /**
     * @var RequestProvider
     */
    protected $request;

    public function testAdd()
    {
        $contact = $this->contact->getContact();
        $url = 'https://domain.amocrm.ru/api/v2/contacts';

        $request = $this->request->getMockedRequest();

        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]]));

        $contact->addCustomField($this->customField->getEmailField());

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$contact->get()]]);

        $contactService = new \linkprofit\AmoCRM\services\ContactService($request);
        $contactService->add($contact);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]], $contactService->save());

        $contactService->parseResponseToEntities();
        $contacts = $contactService->getEntities();

        $this->assertEquals(1, $contacts[0]->id);
    }

    public function testUpdate()
    {
        $contact = $this->contact->getContact();
        $url = 'https://domain.amocrm.ru/api/v2/contacts';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 2]]]]));

        $contact->addCustomField($this->customField->getEmailField());
        $contact->id = 2;

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['update' => [$contact->get()]]);

        $contactService = new \linkprofit\AmoCRM\services\ContactService($request);
        $contactService->add($contact);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 2]]]], $contactService->save());

        $contactService->parseResponseToEntities();
        $contacts = $contactService->getEntities();

        $this->assertEquals(2, $contacts[0]->id);
    }

    public function testAddError()
    {
        $url = 'https://domain.amocrm.ru/api/v2/contacts';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => []]]));

        $contact = $this->contact->getContact();

        $contact->addCustomField($this->customField->getEmailField());

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$contact->get()]]);

        $contactService = new \linkprofit\AmoCRM\services\ContactService($request);
        $contactService->add($contact);

        $this->assertFalse($contactService->save());
        $this->assertFalse($contactService->parseResponseToEntities());
    }

    public function testAddPlural()
    {
        $url = 'https://domain.amocrm.ru/api/v2/contacts';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1], ['id' => 2]]]]));

        $contact = $this->contact->getContact();

        $contact->addCustomField($this->customField->getEmailField());

        $secondContact = $this->contact->getContact();
        $secondContact->name = 'Аркадий Райкин';

        $secondContact->addCustomField($this->customField->getEmailField());

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$contact->get(), $secondContact->get()]]);

        $contactService = new \linkprofit\AmoCRM\services\ContactService($request);
        $contactService->add($contact);
        $contactService->add($secondContact);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1], ['id' => 2]]]], $contactService->save());

        $contacts = $contactService->parseResponseToEntities();

        $this->assertEquals(1, $contacts[0]->id);
        $this->assertEquals(2, $contacts[1]->id);
    }

    public function testParseArrayToEntity()
    {
        $contact = $this->contact->getContact();
        $contactService = new \linkprofit\AmoCRM\services\ContactService($this->request->getMockedRequest());

        $clonedContact = $contactService->parseArrayToEntity($contact->get());
        $this->assertTrue($contact == $clonedContact);
    }

    protected function setUp()
    {
        $this->customField = new CustomFieldProvider();
        $this->contact = new ContactProvider();
        $this->request = new RequestProvider();
    }
}