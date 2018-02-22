<?php

namespace linkprofit\AmoCRM\services;

use linkprofit\AmoCRM\entities\EntityInterface;
use linkprofit\AmoCRM\entities\Customer;
use linkprofit\AmoCRM\RequestHandler;

/**
 * Class CustomerService
 * @package linkprofit\AmoCRM\services
 */
class CustomerService extends BaseService
{
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