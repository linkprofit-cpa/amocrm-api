<?php

use PHPUnit\Framework\TestCase;

class ContactServiceTest extends TestCase
{
    protected $emailField;
    protected $request;

    public function testAdd()
    {
        $contact = $this->contactProvider();
        $url = 'https://domain.amocrm.ru/api/v2/contacts';

        $this->request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]]));

        $contact->addCustomField($this->emailField);

        $this->request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$contact->get()]]);

        $contactService = new \linkprofit\AmoCRM\services\ContactService($this->request);
        $contactService->add($contact);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]], $contactService->create());

        $contactService->parseResponseToEntities();
        $contacts = $contactService->getEntities();

        $this->assertEquals(1, $contacts[0]->id);
    }

    public function testAddError()
    {
        $url = 'https://domain.amocrm.ru/api/v2/contacts';

        $this->request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => []]]));

        $contact = $this->contactProvider();

        $contact->addCustomField($this->emailField);

        $this->request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$contact->get()]]);

        $contactService = new \linkprofit\AmoCRM\services\ContactService($this->request);
        $contactService->add($contact);

        $this->assertFalse($contactService->create());
        $this->assertFalse($contactService->parseResponseToEntities());
    }

    public function testAddPlural()
    {
        $url = 'https://domain.amocrm.ru/api/v2/contacts';

        $this->request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1], ['id' => 2]]]]));

        $contact = $this->contactProvider();

        $contact->addCustomField($this->emailField);

        $secondContact = $this->contactProvider();
        $secondContact->name = 'Аркадий Райкин';

        $secondContact->addCustomField($this->emailField);

        $this->request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$contact->get(), $secondContact->get()]]);

        $contactService = new \linkprofit\AmoCRM\services\ContactService($this->request);
        $contactService->add($contact);
        $contactService->add($secondContact);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1], ['id' => 2]]]], $contactService->create());

        $contacts = $contactService->parseResponseToEntities();

        $this->assertEquals(1, $contacts[0]->id);
        $this->assertEquals(2, $contacts[1]->id);
    }

    public function testParseArrayToEntity()
    {
        $contact = $this->contactProvider();
        $contactService = new \linkprofit\AmoCRM\services\ContactService($this->requestProvider());

        $clonedContact = $contactService->parseArrayToEntity($contact->get());
        $this->assertTrue($contact == $clonedContact);
    }

    protected function setUp()
    {
        $this->emailField = $this->emailFieldProvider();
        $this->request = $this->requestProvider();
    }

    protected function emailFieldProvider()
    {
        $emailField = new \linkprofit\AmoCRM\entities\CustomField('146785', 'email', 'EMAIL');
        $emailField->addValue(new \linkprofit\AmoCRM\entities\Value(
                'email@email.com', '304683'
            )
        );

        return $emailField;
    }

    protected function contactProvider()
    {
        $contact = new \linkprofit\AmoCRM\entities\Contact();
        $contact->responsible_user_id = 1924000;
        $contact->name = 'Василий Аркадьевич';

        return $contact;
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