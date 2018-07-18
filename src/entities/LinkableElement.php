<?php

namespace linkprofit\AmoCRM\entities;

/**
 * Interface LinkableElement
 * @package linkprofit\AmoCRM\entities
 */
interface LinkableElement
{
    /**
     * @param $entityClass
     *
     * @return bool
     */
    public function supports($entityClass);

    /**
     * @param LinkElementCapableEntity $entity
     *
     * @return LinkElementCapableEntity
     */
    public function linkSelf(LinkElementCapableEntity $entity);
}