<?php

namespace linkprofit\AmoCRM\services;

use linkprofit\AmoCRM\entities\Authorization;
use linkprofit\AmoCRM\RequestHandler;

class AuthorizationService
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
     * @var
     */
    protected $response;

    /**
     * @var Authorization
     */
    protected $authorization;

    /**
     * AuthorizationService constructor.
     * @param RequestHandler $request
     * @param Authorization $authorization
     */
    public function __construct(RequestHandler $request, Authorization $authorization)
    {
        $this->request = $request;
        $this->add($authorization);
    }

    /**
     * @param Authorization $authorization
     */
    public function add(Authorization $authorization)
    {
        $this->authorization = $authorization;
    }

    /**
     * @return bool
     */
    public function authorize()
    {
        $this->composeFields();
        $this->request->performRequest($this->getAuthLink(), $this->fields);
        $this->response = $this->request->getResponse();

        return $this->checkResponse();
    }

    /**
     * @return bool
     */
    protected function checkResponse()
    {
        if (isset($this->response['auth'])) {
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
     * Fill fields for response
     */
    protected function composeFields()
    {
        $this->fields['USER_LOGIN'] = $this->authorization->login;
        $this->fields['USER_HASH'] = $this->authorization->apiHash;
    }
}