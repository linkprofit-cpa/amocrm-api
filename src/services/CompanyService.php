<?php

namespace linkprofit\AmoCRM\services;

use linkprofit\AmoCRM\entities\Company;
use linkprofit\AmoCRM\entities\EntityInterface;

/**
 * Class CompanyService
 * @package linkprofit\AmoCRM\services
 */
class CompanyService extends BaseService
{
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