<?php

namespace linkprofit\AmoCRM\services;

use linkprofit\AmoCRM\entities\Authorization;
use linkprofit\AmoCRM\entities\EntityInterface;
use linkprofit\AmoCRM\RequestHandler;

/**
 * Class AuthorizationService
 * @package linkprofit\AmoCRM\services
 */
class AuthorizationService implements ServiceInterface
{
    /**
     * @var RequestHandler
     */
    protected $request;

    /**
     * @var array
     */
    protected $fields;

    /**
     * @var mixed
     */
    protected $response;

    /**
     * @var Authorization
     */
    protected $authorization;

    /**
     * AuthorizationService constructor.
     * @param RequestHandler $request
     */
    public function __construct(RequestHandler $request)
    {
        $this->request = $request;
    }

    /**
     * @param Authorization $authorization
     */
    public function add(EntityInterface $authorization)
    {
        if ($authorization instanceof Authorization) {
            $this->authorization = $authorization;
        }
    }

    /**
     * @return bool
     */
    public function authorize()
    {
        $this->composeFields();
        $this->request->performRequest($this->getAuthLink(), $this->fields);
        $this->response = $this->request->getResponse();
        $this->response = $this->response['response'];

        return $this->checkResponse();
    }

    /**
     * @return bool
     */
    protected function checkResponse()
    {
        if (isset($this->response['auth']) && $this->response['auth'] !== false) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    protected function getAuthLink()
    {
        return 'https://' . $this->request->getSubdomain() . '.amocrm.ru/private/api/auth.php?type=json';
    }

    /**
     * Fill fields for request
     */
    protected function composeFields()
    {
        $this->fields = $this->authorization->get();
    }
}