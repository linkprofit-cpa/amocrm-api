<?php

namespace linkprofit\AmoCRM\services;

use linkprofit\AmoCRM\entities\EntityInterface;
use linkprofit\AmoCRM\entities\Lead;
use linkprofit\AmoCRM\RequestHandler;

/**
 * Class LeadService
 * @package linkprofit\AmoCRM\services
 */
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
    protected $leads = [];

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
            $this->leads[] = $lead;
        }
    }

    /**
     * @return bool|mixed
     */
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

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return array
     */
    public function getLeads()
    {
        return $this->leads;
    }

    /**
     * @return array|bool
     */
    public function parseResponseToLeads()
    {
        if (!$this->checkResponse()) {
            return false;
        }
        $this->leads = [];

        foreach ($this->response['_embedded']['items'] as $item) {
            $lead = new Lead();
            $lead->set($item);

            $this->leads[] = $lead;
        }

        return $this->leads;
    }

    /**
     * @return bool
     */
    protected function checkResponse()
    {
        if (isset($this->response['_embedded']['items']) && count($this->response['_embedded']['items'])) {
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
     * Fill fields for request
     */
    protected function composeAddFields()
    {
        $fields = [];

        foreach ($this->leads as $lead) {
            $fields[] = $lead->get();
        }

        $this->fields['add'] = $fields;
    }
}