<?php

namespace linkprofit\AmoCRM\tests\services;

use linkprofit\AmoCRM\tests\providers\CatalogProvider;
use linkprofit\AmoCRM\tests\providers\RequestProvider;
use PHPUnit\Framework\TestCase;

class CatalogServiceTest extends TestCase
{
    /**
     * @var \linkprofit\AmoCRM\tests\providers\CatalogProvider
     */
    protected $catalog;
    /**
     * @var RequestProvider
     */
    protected $request;

    public function testAdd()
    {
        $url = 'https://domain.amocrm.ru/api/v2/catalogs';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($this->responseProvider()));

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$this->catalog->getCatalog()->get()]]);

        $catalogService = new \linkprofit\AmoCRM\services\CatalogService($request);
        $catalogService->add($this->catalog->getCatalog());

        $this->assertEquals($this->responseProvider(), $catalogService->save());

        $catalogService->parseResponseToEntities();
        $catalog = $catalogService->getEntities();

        $this->assertEquals(1, $catalog[0]->id);
    }

    public function testUpdate()
    {
        $url = 'https://domain.amocrm.ru/api/v2/catalogs';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($this->responseProvider()));

        $catalog = $this->catalog->getCatalog();
        $catalog->id = 1;
        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['update' => [$catalog->get()]]);

        $catalogService = new \linkprofit\AmoCRM\services\CatalogService($request);
        $catalogService->add($catalog);

        $this->assertEquals($this->responseProvider(), $catalogService->save());

        $catalogService->parseResponseToEntities();
        $catalogs = $catalogService->getEntities();

        $this->assertEquals(1, $catalogs[0]->id);
    }

    public function testAddError()
    {
        $url = 'https://domain.amocrm.ru/api/v2/catalogs';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['_links' => ['self'], '_embedded' => ['items' => []]]));

        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, ['add' => [$this->catalog->getCatalog()->get()]]);


        $catalogService = new \linkprofit\AmoCRM\services\CatalogService($request);
        $catalogService->add($this->catalog->getCatalog());

        $this->assertFalse($catalogService->save());
        $this->assertFalse($catalogService->parseResponseToEntities());
    }

    public function testParseArrayToEntity()
    {
        $catalog = $this->catalog->getCatalog();
        $catalogService = new \linkprofit\AmoCRM\services\CatalogService($this->request->getMockedRequest());

        $clonedTask = $catalogService->parseArrayToEntity($catalog->get());
        $this->assertTrue($catalog == $clonedTask);
    }

    public function testDeprecatedLists()
    {
        $url = 'https://domain.amocrm.ru/api/v2/catalogs?';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($this->responseProvider()));

        $catalog = $this->catalog->getCatalog();
        $catalog->id = 1;
        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, [], 'application/json', 'GET');

        $catalogService = new \linkprofit\AmoCRM\services\CatalogService($request);
        $catalogService->add($catalog);

        $this->assertEquals($catalog->id, $catalogService->lists()[0]->id);
    }

    public function testList()
    {
        $url = 'https://domain.amocrm.ru/api/v2/catalogs?';

        $request = $this->request->getMockedRequest();
        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($this->responseProvider()));

        $catalog = $this->catalog->getCatalog();
        $catalog->id = 1;
        $request->expects($this->once())
            ->method('performRequest')
            ->with($url, [], 'application/json', 'GET');

        $catalogService = new \linkprofit\AmoCRM\services\CatalogService($request);
        $catalogService->add($catalog);

        $this->assertEquals($catalog->id, $catalogService->getList()[0]->id);
    }

    protected function setUp()
    {
        $this->request = new RequestProvider();
        $this->catalog = new CatalogProvider();
    }

    protected function responseProvider()
    {
        return ['_links' => ['self'], '_embedded' => ['items' => [['id' => 1]]]];
    }
}