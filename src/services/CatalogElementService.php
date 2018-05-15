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
     * @param string|null $query
     * @param array $params
     *
     * @return array|bool
     */
    public function lists($page = 1, $query = null, array $params = null)
    {
        $queryParams = [];
        $queryParams['PAGEN_1'] = $page;

        if (!empty($query)) {
            $queryParams['term'] = $query;
        }

        if ($params) {
            $queryParams = array_merge($queryParams, $params);
        }

        $link = $this->getLink() . '?' . http_build_query($queryParams);

        $this->request->performRequest($link, [], 'application/json', 'GET');
        $this->response = $this->request->getResponse();

        return $this->parseResponseToEntities();
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