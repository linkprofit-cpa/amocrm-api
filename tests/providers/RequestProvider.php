<?php

namespace linkprofit\AmoCRM\tests\providers;


use PHPUnit\Framework\TestCase;

class RequestProvider extends TestCase
{
    public function getMockedRequest()
    {
        $request = $this->getMockBuilder(\linkprofit\AmoCRM\RequestHandler::class)
            ->setMethods(['getSubdomain', 'performRequest', 'getResponse'])
            ->getMock();

        $request->expects($this->once())
            ->method('getSubdomain')
            ->will($this->returnValue('domain'));

        return $request;
    }
}