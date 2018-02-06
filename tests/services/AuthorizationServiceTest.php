<?php

use PHPUnit\Framework\TestCase;

class AuthorizationServiceTest extends TestCase
{
    public function testSuccessAuthorize()
    {
        $request = $this->getMockBuilder(\linkprofit\AmoCRM\RequestHandler::class)
            ->setMethods(['getSubdomain', 'performRequest', 'getResponse'])
            ->getMock();

        $request->expects($this->once())
            ->method('getSubdomain')
            ->will($this->returnValue('domain'));

        $authUrl = 'https://domain.amocrm.ru/private/api/auth.php?type=json';
        $request->expects($this->once())
            ->method('performRequest')
            ->with($authUrl, ['USER_LOGIN' => 'login', 'USER_HASH' => 'api_key']);

        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['response' => ['auth' => 'success']]));

        $authorization = new \linkprofit\AmoCRM\entities\Authorization('login', 'api_key');
        $authorizationService = new \linkprofit\AmoCRM\services\AuthorizationService($request);
        $authorizationService->add($authorization);

        $this->assertTrue($authorizationService->authorize());
    }

    public function testErrorAuthorize()
    {
        $request = $this->getMockBuilder(\linkprofit\AmoCRM\RequestHandler::class)
            ->setMethods(['getSubdomain', 'performRequest', 'getResponse'])
            ->getMock();

        $request->expects($this->once())
            ->method('getSubdomain')
            ->will($this->returnValue('domain'));

        $authUrl = 'https://domain.amocrm.ru/private/api/auth.php?type=json';
        $request->expects($this->once())
            ->method('performRequest')
            ->with($authUrl, ['USER_LOGIN' => 'login', 'USER_HASH' => 'api_key']);

        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['response' => []]));

        $authorization = new \linkprofit\AmoCRM\entities\Authorization('login', 'api_key');
        $authorizationService = new \linkprofit\AmoCRM\services\AuthorizationService($request);
        $authorizationService->add($authorization);

        $this->assertFalse($authorizationService->authorize());
    }
}