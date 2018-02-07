<?php

namespace linkprofit\AmoCRM\services;

use linkprofit\AmoCRM\entities\EntityInterface;
use linkprofit\AmoCRM\RequestHandler;

/**
 * Interface ServiceInterface
 * @package linkprofit\AmoCRM\services
 */
interface ServiceInterface
{
    /**
     * ServiceInterface constructor.
     * @param RequestHandler $requestHandler
     */
    public function __construct(RequestHandler $requestHandler);

    /**
     * @param EntityInterface $entity
     * @return mixed
     */
    public function add(EntityInterface $entity);
}