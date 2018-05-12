<?php

namespace linkprofit\AmoCRM\services;

use linkprofit\AmoCRM\entities\Catalog;
use linkprofit\AmoCRM\entities\EntityInterface;

/**
 * Class CatalogService
 *
 * @package linkprofit\AmoCRM\services
 */
class CatalogService extends BaseService
{
    /**
     * @var Catalog[]
     */
    protected $entities = [];

    /**
     * @param Catalog $catalog
     */
    public function add(EntityInterface $catalog)
    {
        if ($catalog instanceof Catalog) {
            $this->entities[] = $catalog;
        }
    }

    /**
     * @param null $id
     *
     * @return array|bool
     */
    public function lists($id = null)
    {
        $link = $this->getLink();

        if ($id !== null) {
            $link .= '?id' . $id;
        }

        $this->request->performRequest($link, [], 'application/json', 'GET');
        $this->response = $this->request->getResponse();

        return $this->parseResponseToEntities();
    }

    /**
     * @param $array
     * 
     * @return Catalog
     */
    public function parseArrayToEntity($array)
    {
        $catalog = new Catalog();
        $catalog->set($array);

        return $catalog;
    }

    /**
     * @return string
     */
    protected function getLink()
    {
        return 'https://' . $this->request->getSubdomain() . '.amocrm.ru/api/v2/catalogs';
    }

}