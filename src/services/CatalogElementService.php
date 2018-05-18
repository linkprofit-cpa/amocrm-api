<?php

namespace linkprofit\AmoCRM\services;

use linkprofit\AmoCRM\entities\CatalogElement;
use linkprofit\AmoCRM\entities\CustomField;
use linkprofit\AmoCRM\entities\EntityInterface;
use linkprofit\AmoCRM\entities\Value;

/**
 * Class CatalogElementService
 *
 * @package linkprofit\AmoCRM\services
 */
class CatalogElementService extends BaseService
{
    /**
     * @var CatalogElement[]
     */
    protected $entities = [];

    /**
     * @var int
     */
    protected $listPage = 1;

    /**
     * @var string
     */
    protected $listQuery;

    /**
     * @var array
     */
    protected $listParams = [];

    /**
     * @param EntityInterface|CatalogElement $catalogElement
     */
    public function add(EntityInterface $catalogElement)
    {
        if ($catalogElement instanceof CatalogElement) {
            $this->entities[] = $catalogElement;
        }
    }

    /**
     * @param int $page
     *
     * @return $this
     */
    public function setPage($page)
    {
        $this->listPage = $page;

        return $this;
    }

    /**
     * @param string $query
     *
     * @return $this
     */
    public function setQuery($query)
    {
        $this->listQuery = $query;

        return $this;
    }

    /**
     * @param array $params
     *
     * @return $this
     */
    public function setParams(array $params)
    {
        $this->listParams = $params;

        return $this;
    }

    /**
     * @param $link
     *
     * @return string
     */
    protected function composeListLink($link)
    {
        $query = [];

        $query['PAGEN_1'] = $this->listPage;

        if (!empty($this->listQuery)) {
            $query['term'] = $this->listQuery;
        }

        $query = array_merge($query, $this->listParams);

        $link .= '?' . http_build_query($query);

        return $link;
    }

    /**
     * @deprecated
     *
     * @param int $page
     * @param string|null $query
     * @param array $params
     *
     * @return array|bool
     */
    public function lists($page = 1, $query = null, array $params = [])
    {
        $this->listPage = $page;
        $this->listQuery = $query;
        $this->listParams = $params;

        return $this->getList();
    }

    /**
     * @param $array
     *
     * @return CatalogElement
     */
    public function parseArrayToEntity($array)
    {
        $element = new CatalogElement();
        $element->set($array);

        if (isset($array['custom_fields'])) {
            foreach ($array['custom_fields'] as $customFieldArray) {
                $customField = new CustomField($customFieldArray['id']);
                $customField->set($customFieldArray);

                if (isset($customFieldArray['values'])) {
                    foreach ($customFieldArray['values'] as $value) {
                        $value = new Value($value);
                        $customField->addValue($value);
                    }
                }

                $element->addCustomField($customField);
            }
        }

        return $element;
    }

    /**
     * @return string
     */
    protected function getLink()
    {
        return 'https://' . $this->request->getSubdomain() . '.amocrm.ru/api/v2/catalog_elements';
    }

}