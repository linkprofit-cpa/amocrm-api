<?php

namespace linkprofit\AmoCRM\services;

use linkprofit\AmoCRM\entities\Catalog;
use linkprofit\AmoCRM\entities\EntityInterface;
use linkprofit\AmoCRM\traits\IdentifiableList;
use linkprofit\AmoCRM\traits\PaginableList;

/**
 * Class CatalogService
 *
 * @package linkprofit\AmoCRM\services
 */
class CatalogService extends BaseService implements ListableService
{
    use IdentifiableList, PaginableList;

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
     * @deprecated
     *
     * @param int|null
     *
     * @return array|bool
     */
    public function lists($id = null)
    {
        if ($id !== null) {
            $this->setId($id);
        }

        return $this->getList();
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