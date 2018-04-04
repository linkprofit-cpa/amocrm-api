<?php

namespace linkprofit\AmoCRM\services;

use linkprofit\AmoCRM\entities\EntityInterface;
use linkprofit\AmoCRM\entities\Pipeline;
use linkprofit\AmoCRM\RequestHandler;

/**
 * Class PipelineService
 * @package linkprofit\AmoCRM\services
 */
class PipelineService extends BaseService
{
    /**
     * @var Pipeline[]
     */
    protected $entities = [];

    /**
     * @param Pipeline $pipeline
     */
    public function add(EntityInterface $pipeline)
    {
        if ($pipeline instanceof Pipeline) {
            $this->entities[] = $pipeline;
        }
    }

    /**
     * @param $array
     * @return Pipeline
     */
    public function parseArrayToEntity($array)
    {
        $pipeline = new Pipeline();
        $pipeline->set($array);

        return $pipeline;
    }

    /**
     * @return string
     */
    protected function getLink()
    {
        return 'https://' . $this->request->getSubdomain() . '.amocrm.ru/private/api/v2/json/pipelines/set';
    }
}