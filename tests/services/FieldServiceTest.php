<?php

use PHPUnit\Framework\TestCase;
use linkprofit\AmoCRM\entities\Field;

class FieldServiceTest extends TestCase
{
    protected $emailField;
    protected $request;

    public function testAdd()
    {
        $url = 'https://domain.amocrm.ru/api/v2/fields';

        $this->request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]]));

        $field = $this->fieldProvider();

        $this->request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$field->get()]]);

        $fieldService = new \linkprofit\AmoCRM\services\FieldService($this->request);
        $fieldService->add($field);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]], $fieldService->save());

        $fieldService->parseResponseToEntities();
        $fields = $fieldService->getEntities();

        $this->assertEquals(1, $fields[0]->id);
    }

    public function testAddError()
    {
        $url = 'https://domain.amocrm.ru/api/v2/fields';

        $this->request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => []]]));

        $field = $this->fieldProvider();

        $this->request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$field->get()]]);

        $fieldService = new \linkprofit\AmoCRM\services\FieldService($this->request);
        $fieldService->add($field);

        $this->assertFalse($fieldService->save());
        $this->assertFalse($fieldService->parseResponseToEntities());
    }

    public function testParseArrayToEntity()
    {
        $field = $this->fieldProvider();
        $fieldService = new \linkprofit\AmoCRM\services\FieldService($this->requestProvider());

        $clonedField = $fieldService->parseArrayToEntity($field->get());
        $this->assertTrue($field == $clonedField);
    }

    protected function setUp()
    {
        $this->request = $this->requestProvider();
    }

    protected function fieldProvider()
    {
        $field = new Field();
        $field->origin = 'origin_field';
        $field->is_editable = true;
        $field->name = 'Новое поле';
        $field->element_type = Field::CONTACT_ELEMENT_TYPE;
        $field->field_type = Field::TEXT;

        return $field;
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