<?php

namespace linkprofit\AmoCRM\traits;

/**
 * Trait IdentifiableList
 * @package linkprofit\AmoCRM\traits
 */
trait IdentifiableList
{
    /**
     * @var int
     */
    protected $listId;

    /**
     * @param $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->listId = $id;

        return $this;
    }

    /**
     * @param array $query
     *
     * @return array
     */
    public function addIdToQuery($query = [])
    {
        if ($this->listId !== null) {
            $query['id'] = $this->listId;
        }

        return $query;
    }
}