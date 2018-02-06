<?php

namespace linkprofit\AmoCRM\services;

use linkprofit\AmoCRM\entities\EntityInterface;
use linkprofit\AmoCRM\entities\Lead;
use linkprofit\AmoCRM\RequestHandler;

class LeadService implements ServiceInterface
{
    /**
     * @var RequestHandler
     */
    protected $request;

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var
     */
    protected $response;

    /**
     * @var array Lead
     */
    protected $lead = [];

    /**
     * LeadService constructor.
     * @param RequestHandler $requestHandler
     */
    public function __construct(RequestHandler $requestHandler)
    {
        $this->request = $requestHandler;
    }

    /**
     * @param Lead $lead
     */
    public function add(EntityInterface $lead)
    {
        if ($lead instanceof Lead) {
            $this->lead[] = $lead;
        }
    }

    public function createLead()
    {
        $this->composeAddFields();
        $this->request->performRequest($this->getLink(), $this->fields);
        $this->response = $this->request->getResponse();

        if ($this->checkResponse()) {
            return $this->getResponse();
        }

        return false;
    }

    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return bool
     */
    protected function checkResponse()
    {
        if (isset($this->response['_embedded']['items'])) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    protected function getLink()
    {
        return 'https://' . $this->request->getSubdomain() . '.amocrm.ru/api/v2/leads';
    }

    /**
     * Fill fields for response
     */
    protected function composeAddFields()
    {
       $fields = [];

       foreach ($this->lead as $lead) {
           $fields[] = $lead->get();
       }

        $this->fields['add'] = $fields;
    }
}