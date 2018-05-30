<?php

namespace linkprofit\AmoCRM\tests\services;

use linkprofit\AmoCRM\tests\providers\CatalogElementProvider;
use linkprofit\AmoCRM\tests\providers\CustomFieldProvider;
use linkprofit\AmoCRM\tests\providers\RequestProvider;
use PHPUnit\Framework\TestCase;

class CatalogElementServiceTest extends TestCase
{
    /**
     * @var CustomFieldProvider
     */
    protected $customField;

    /**
     * @var CatalogElementProvider
     */
    protected $element;

    /**
     * @var RequestProvider
     */
    protected $request;

    public function testAdd()
    {
        $url = 'https://domain.amocrm.ru/api/v2/catalog_elements';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]]));

        $element = $this->element->getElement();

        $element->addCustomField($this->customField->getEmailField());

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$element->get()]]);

        $service = new \linkprofit\AmoCRM\services\CatalogElementService($request);
        $service->add($element);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]], $service->save());

        $service->parseResponseToEntities();
        $leads = $service->getEntities();

        $this->assertEquals(1, $leads[0]->id);
    }

    public function testUpdate()
    {
        $url = 'https://domain.amocrm.ru/api/v2/catalog_elements';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 2]]]]));

        $element = $this->element->getElement();
        $element->id = 2;

        $element->addCustomField($this->customField->getEmailField());

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['update' => [$element->get()]]);

        $service = new \linkprofit\AmoCRM\services\CatalogElementService($request);
        $service->add($element);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 2]]]], $service->save());

        $service->parseResponseToEntities();
        $leads = $service->getEntities();

        $this->assertEquals(2, $leads[0]->id);
    }

    public function testAddError()
    {
        $url = 'https://domain.amocrm.ru/api/v2/catalog_elements';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => []]]));

        $elements = $this->element->getElement();

        $elements->addCustomField($this->customField->getEmailField());

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$elements->get()]]);

        $service = new \linkprofit\AmoCRM\services\CatalogElementService($request);
        $service->add($elements);

        $this->assertFalse($service->save());
        $this->assertFalse($service->parseResponseToEntities());
    }

    public function testAddPlural()
    {
        $url = 'https://domain.amocrm.ru/api/v2/catalog_elements';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1], ['id' => 2]]]]));

        $element = $this->element->getElement();

        $element->addCustomField($this->customField->getEmailField());

        $secondElement = $this->element->getElement();
        $secondElement->sale = 300;

        $secondElement->addCustomField($this->customField->getEmailField());

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$element->get(), $secondElement->get()]]);

        $service = new \linkprofit\AmoCRM\services\CatalogElementService($request);
        $service->add($element);
        $service->add($secondElement);

        $this->assertEquals(['_links' => ['self'], '_embedded' => ['items' => [['id' => 1], ['id' => 2]]]], $service->save());

        $elements = $service->parseResponseToEntities();

        $this->assertEquals(1, $elements[0]->id);
        $this->assertEquals(2, $elements[1]->id);
    }

    public function testParseArrayToEntity()
    {
        $element = $this->element->getElement();
        $service = new \linkprofit\AmoCRM\services\CatalogElementService($this->request->getMockedRequest());

        $clonedLead = $service->parseArrayToEntity($element->get());
        $this->assertTrue($element == $clonedLead);
    }

    public function testDeprecatedListsNotParams()
    {
        $url = 'https://domain.amocrm.ru/api/v2/catalog_elements?PAGEN_1=1';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($this->responseProvider()));

        $element = $this->element->getElement();
        $element->id = 1;
        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, [], 'application/json', 'GET');

        $service = new \linkprofit\AmoCRM\services\CatalogElementService($request);
        $service->add($element);

        $this->assertEquals($element->id, $service->lists()[0]->id);
    }

    public function testListNotParams()
    {
        $url = 'https://domain.amocrm.ru/api/v2/catalog_elements?PAGEN_1=1';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($this->responseProvider()));

        $element = $this->element->getElement();
        $element->id = 1;
        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, [], 'application/json', 'GET');

        $service = new \linkprofit\AmoCRM\services\CatalogElementService($request);
        $service->add($element);

        $this->assertEquals($element->id, $service->getList()[0]->id);
    }

    public function testListPage()
    {
        $url = 'https://domain.amocrm.ru/api/v2/catalog_elements?PAGEN_1=2';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($this->responseProvider()));

        $element = $this->element->getElement();
        $element->id = 1;
        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, [], 'application/json', 'GET');

        $service = new \linkprofit\AmoCRM\services\CatalogElementService($request);
        $service->add($element);

        $this->assertEquals($element->id, $service->lists(2)[0]->id);
    }

    public function testDeprecatedListsQuery()
    {
        $url = 'https://domain.amocrm.ru/api/v2/catalog_elements?PAGEN_1=1&term=test';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($this->responseProvider()));

        $element = $this->element->getElement();
        $element->id = 1;
        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, [], 'application/json', 'GET');

        $service = new \linkprofit\AmoCRM\services\CatalogElementService($request);
        $service->add($element);

        $this->assertEquals($element->id, $service->lists(1, 'test')[0]->id);
    }

    public function testListQuery()
    {
        $url = 'https://domain.amocrm.ru/api/v2/catalog_elements?PAGEN_1=1&term=test';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($this->responseProvider()));

        $element = $this->element->getElement();
        $element->id = 1;
        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, [], 'application/json', 'GET');

        $service = new \linkprofit\AmoCRM\services\CatalogElementService($request);
        $service->add($element);

        $this->assertEquals($element->id, $service->setPage(1)->setQuery('test')->getList()[0]->id);
    }

    public function testDeprecatedListsParams()
    {
        $url = 'https://domain.amocrm.ru/api/v2/catalog_elements?PAGEN_1=1&term=test&catalog_id=123';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($this->responseProvider()));

        $element = $this->element->getElement();
        $element->id = 1;
        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, [], 'application/json', 'GET');

        $service = new \linkprofit\AmoCRM\services\CatalogElementService($request);
        $service->add($element);

        $testElement = $service->lists(1, 'test', ['catalog_id'=>123])[0]->get();

        $this->assertEquals($element->id, $testElement['id']);
        $this->assertEquals(1234, $testElement['custom_fields'][0]['id']);
        $this->assertEquals('testValue', $testElement['custom_fields'][0]['values'][0]['value']);
    }

    public function testListParams()
    {
        $url = 'https://domain.amocrm.ru/api/v2/catalog_elements?PAGEN_1=1&term=test&catalog_id=123';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($this->responseProvider()));

        $element = $this->element->getElement();
        $element->id = 1;
        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, [], 'application/json', 'GET');

        $service = new \linkprofit\AmoCRM\services\CatalogElementService($request);
        $service->add($element);

        $testElement = $service->setPage(1)->setQuery('test')->setParams(['catalog_id'=>123])->getList()[0]->get();

        $this->assertEquals($element->id, $testElement['id']);
        $this->assertEquals(1234, $testElement['custom_fields'][0]['id']);
        $this->assertEquals('testValue', $testElement['custom_fields'][0]['values'][0]['value']);
    }

    protected function setUp()
    {
        $this->customField = new CustomFieldProvider();
        $this->request = new RequestProvider();
        $this->element = new CatalogElementProvider();
    }

    protected function responseProvider()
    {
        return [
            '_links'    => ['self'],
            '_embedded' => [
                'items' => [
                    [
                        'id'            => 1,
                        'custom_fields' => [
                            [
                                'id'     => 1234,
                                'values' => [
                                    'testValue',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

}