<?php

namespace linkprofit\AmoCRM\tests\services;

use linkprofit\AmoCRM\tests\providers\CustomFieldProvider;
use linkprofit\AmoCRM\tests\providers\FieldProvider;
use linkprofit\AmoCRM\tests\providers\RequestProvider;
use PHPUnit\Framework\TestCase;
use linkprofit\AmoCRM\entities\Field;

class FieldServiceTest extends TestCase
{
    /**
     * @var CustomFieldProvider
     */
    protected $customField;

    /**
     * @var FieldProvider
     */
    protected $field;

    /**
     * @var RequestProvider
     */
    protected $request;

    public function testAdd()
    {
        $url = 'https://domain.amocrm.ru/api/v2/fields';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]]));

        $field = $this->field->getField();

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$field->get()]]);

        $fieldService = new \linkprofit\AmoCRM\services\FieldService($request);
        $fieldService->add($field);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]], $fieldService->save());

        $fieldService->parseResponseToEntities();
        $fields = $fieldService->getEntities();

        $this->assertEquals(1, $fields[0]->id);
    }

    public function testUpdate()
    {
        $url = 'https://domain.amocrm.ru/api/v2/fields';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 2]]]]));

        $field = $this->field->getField();
        $field->id = 2;

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['update' => [$field->get()]]);

        $fieldService = new \linkprofit\AmoCRM\services\FieldService($request);
        $fieldService->add($field);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 2]]]], $fieldService->save());

        $fieldService->parseResponseToEntities();
        $fields = $fieldService->getEntities();

        $this->assertEquals(2, $fields[0]->id);
    }

    public function testAddError()
    {
        $url = 'https://domain.amocrm.ru/api/v2/fields';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => []]]));

        $field = $this->field->getField();

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$field->get()]]);

        $fieldService = new \linkprofit\AmoCRM\services\FieldService($request);
        $fieldService->add($field);

        $this->assertFalse($fieldService->save());
        $this->assertFalse($fieldService->parseResponseToEntities());
    }

    public function testParseArrayToEntity()
    {
        $field = $this->field->getField();
        $fieldService = new \linkprofit\AmoCRM\services\FieldService($this->request->getMockedRequest());

        $clonedField = $fieldService->parseArrayToEntity($field->get());
        $this->assertTrue($field == $clonedField);
    }

    protected function setUp()
    {
        $this->customField = new CustomFieldProvider();
        $this->request = new RequestProvider();
        $this->field = new FieldProvider();
    }
}