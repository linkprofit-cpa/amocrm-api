<?php

namespace linkprofit\AmoCRM\tests;

use PHPUnit\Framework\TestCase;

class RequestHandlerTest extends TestCase
{
    public function testSetSubdomain()
    {
        $request = new \linkprofit\AmoCRM\RequestHandler();
        $request->setSubdomain('domain');

        $this->assertEquals('domain', $request->getSubdomain());
    }

    public function testEmptyResponse()
    {
        $request = new \linkprofit\AmoCRM\RequestHandler();
        $this->assertFalse($request->getResponse());
    }

    public function testEncodeResponseSuccess()
    {
        $request = new \linkprofit\AmoCRM\RequestHandler();

        $reflection = new \ReflectionClass(get_class($request));

        $request->setSubdomain('domain');

        $request->performRequest('linkdoesnotmatter', []);

        $responseField = $reflection->getProperty('response');
        $responseField->setAccessible(true);
        $responseField->setValue($request, json_encode(['response' => ['auth' => 'success']]));

        $httpCodeField = $reflection->getProperty('httpCode');
        $httpCodeField->setAccessible(true);
        $httpCodeField->setValue($request,  200);

        $this->assertEquals(['response' => ['auth' => 'success']], $request->getResponse());
    }

    public function testEncodeResponseKnownException()
    {
        $request = new \linkprofit\AmoCRM\RequestHandler();

        $reflection = new \ReflectionClass(get_class($request));

        $request->setSubdomain('domain');

        $request->performRequest('linkdoesnotmatter', []);

        $responseField = $reflection->getProperty('response');
        $responseField->setAccessible(true);
        $responseField->setValue($request, json_encode([]));

        $httpCodeField = $reflection->getProperty('httpCode');
        $httpCodeField->setAccessible(true);
        $httpCodeField->setValue($request,  500);

        $request->getResponse();
        $this->expectOutputString('Error: Internal server error' . PHP_EOL . 'Error code: ' . 500);
    }

    public function testEncodeResponseUnknownException()
    {
        $request = new \linkprofit\AmoCRM\RequestHandler();

        $reflection = new \ReflectionClass(get_class($request));

        $request->setSubdomain('domain');

        $request->performRequest('linkdoesnotmatter', []);

        $responseField = $reflection->getProperty('response');
        $responseField->setAccessible(true);
        $responseField->setValue($request, json_encode([]));

        $httpCodeField = $reflection->getProperty('httpCode');
        $httpCodeField->setAccessible(true);
        $httpCodeField->setValue($request,  508);

        $request->getResponse();
        $this->expectOutputString('Error: Undescribed error' . PHP_EOL . 'Error code: ' . 508);
    }
}