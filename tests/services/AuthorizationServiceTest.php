<?php

namespace linkprofit\AmoCRM\tests\services;

use PHPUnit\Framework\TestCase;
use linkprofit\AmoCRM\tests\providers\RequestProvider;

class AuthorizationServiceTest extends TestCase
{
    /**
     * @var RequestProvider
     */
    protected $request;

    public function testSuccess()
    {
        $request = $this->request->getMockedRequest();

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

    public function testError()
    {
        $request = $this->request->getMockedRequest();

        $authUrl = 'https://domain.amocrm.ru/private/api/auth.php?type=json';
        $request->expects($this->once())
            ->method('performRequest')
            ->with($authUrl, ['USER_LOGIN' => 'login', 'USER_HASH' => 'api_key']);

        $request->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(['response' => ['auth' => false]]));

        $authorization = new \linkprofit\AmoCRM\entities\Authorization('login', 'api_key');
        $authorizationService = new \linkprofit\AmoCRM\services\AuthorizationService($request);
        $authorizationService->add($authorization);

        $this->assertFalse($authorizationService->authorize());
    }

    protected function setUp()
    {
        $this->request = new RequestProvider();
    }
}