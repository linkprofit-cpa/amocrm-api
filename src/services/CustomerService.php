<?php

namespace linkprofit\AmoCRM\services;

use linkprofit\AmoCRM\entities\EntityInterface;
use linkprofit\AmoCRM\entities\Customer;
use linkprofit\AmoCRM\RequestHandler;
use linkprofit\AmoCRM\traits\IdentifiableList;
use linkprofit\AmoCRM\traits\PaginableList;

/**
 * Class CustomerService
 * @package linkprofit\AmoCRM\services
 */
class CustomerService extends BaseService
{
    use IdentifiableList,
        PaginableList;

    /**
     * @var Customer[]
     */
    protected $entities = [];

    /**
     * @param Customer $customer
     */
    public function add(EntityInterface $customer)
    {
        if ($customer instanceof Customer) {
            $this->entities[] = $customer;
        }
    }

    /**
     * @param $link
     *
     * @return string
     */
    protected function composeListLink($link)
    {
        $query = $this->addIdToQuery();
        $query = $this->addPaginationToQuery($query);

        $link .= '?' . http_build_query($query);

        return $link;
    }

    /**
     * @param $array
     * @return Customer
     */
    public function parseArrayToEntity($array)
    {
        $customer = new Customer();
        $customer->set($array);

        return $customer;
    }

    /**
     * @return string
     */
    protected function getLink()
    {
        return 'https://' . $this->request->getSubdomain() . '.amocrm.ru/api/v2/customers';
    }

}