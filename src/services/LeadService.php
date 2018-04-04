<?php

namespace linkprofit\AmoCRM\services;

use linkprofit\AmoCRM\entities\EntityInterface;
use linkprofit\AmoCRM\entities\Lead;
use linkprofit\AmoCRM\RequestHandler;

/**
 * Class LeadService
 * @package linkprofit\AmoCRM\services
 */
class LeadService extends BaseService
{
    /**
     * @var Lead[]
     */
    protected $entities = [];

    /**
     * @param Lead $lead
     */
    public function add(EntityInterface $lead)
    {
        if ($lead instanceof Lead) {
            $this->entities[] = $lead;
        }
    }

    /**
     * @param $array
     * @return Lead
     */
    public function parseArrayToEntity($array)
    {
        $lead = new Lead();
        $lead->set($array);

        return $lead;
    }

    /**
     * @return string
     */
    protected function getLink()
    {
        return 'https://' . $this->request->getSubdomain() . '.amocrm.ru/api/v2/leads';
    }

}