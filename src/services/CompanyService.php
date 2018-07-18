<?php

namespace linkprofit\AmoCRM\services;

use linkprofit\AmoCRM\entities\Company;
use linkprofit\AmoCRM\entities\EntityInterface;
use linkprofit\AmoCRM\traits\IdentifiableList;
use linkprofit\AmoCRM\traits\PaginableList;
use linkprofit\AmoCRM\traits\TermList;

/**
 * Class CompanyService
 * @package linkprofit\AmoCRM\services
 */
class CompanyService extends BaseService
{
    use IdentifiableList,
        TermList,
        PaginableList;

    /**
     * @var Company[]
     */
    protected $entities = [];

    /**
     * @param Company $company
     */
    public function add(EntityInterface $company)
    {
        if ($company instanceof Company) {
            $this->entities[] = $company;
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
     * @return Company
     */
    public function parseArrayToEntity($array)
    {
        $company = new Company();
        $company->set($array);

        return $company;
    }

    /**
     * @return string
     */
    protected function getLink()
    {
        return 'https://' . $this->request->getSubdomain() . '.amocrm.ru/api/v2/companies';
    }
}