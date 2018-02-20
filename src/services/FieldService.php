<?php

namespace linkprofit\AmoCRM\services;

use linkprofit\AmoCRM\entities\EntityInterface;
use linkprofit\AmoCRM\entities\Field;
use linkprofit\AmoCRM\RequestHandler;

/**
 * Class FieldService
 * @package linkprofit\AmoCRM\services
 */
class FieldService extends BaseService
{
    /**
     * @var array Field
     */
    protected $entities = [];

    /**
     * @param Field $field
     */
    public function add(EntityInterface $lead)
    {
        if ($lead instanceof Field) {
            $this->entities[] = $lead;
        }
    }

    /**
     * @param $array
     * @return Field
     */
    public function parseArrayToEntity($array)
    {
        $field = new Field();
        $field->set($array);

        return $field;
    }

    /**
     * @return string
     */
    protected function getLink()
    {
        return 'https://' . $this->request->getSubdomain() . '.amocrm.ru/api/v2/fields';
    }

}