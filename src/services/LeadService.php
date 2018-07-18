<?php

namespace linkprofit\AmoCRM\services;

use linkprofit\AmoCRM\entities\EntityInterface;
use linkprofit\AmoCRM\entities\Lead;
use linkprofit\AmoCRM\RequestHandler;
use linkprofit\AmoCRM\traits\IdentifiableList;
use linkprofit\AmoCRM\traits\PaginableList;
use linkprofit\AmoCRM\traits\TermList;

/**
 * Class LeadService
 * @package linkprofit\AmoCRM\services
 */
class LeadService extends BaseService
{
    use IdentifiableList,
        TermList,
        PaginableList;

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
     * @param $link
     *
     * @return string
     */
    protected function composeListLink($link)
    {
        $query = $this->addTermToQuery();
        $query = $this->addIdToQuery($query);
        $query = $this->addPaginationToQuery($query);

        $link .= '?' . http_build_query($query);

        return $link;
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