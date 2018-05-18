<?php

namespace linkprofit\AmoCRM\traits;

/**
 * Trait PaginableList
 * @package linkprofit\AmoCRM\traits
 */
trait PaginableList
{
    /**
     * @var int
     */
    protected $listLimit;

    /**
     * @var int
     */
    protected $listOffset;

    /**
     * @param $limit
     *
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->listLimit = $limit;

        return $this;
    }

    /**
     * @param $offset
     *
     * @return $this
     */
    public function setOffset($offset)
    {
        $this->listOffset = $offset;

        return $this;
    }

    /**
     * @param array $query
     *
     * @return array
     */
    public function addPaginationToQuery($query = [])
    {
        if ($this->listLimit !== null) {
            $query['limit_rows'] = $this->listLimit;
        }

        if ($this->listOffset !== null) {
            $query['limit_offset'] = $this->listOffset;
        }

        return $query;
    }
}