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
     * @param string $link
     *
     * @return string
     */
    public function addPaginationToLink($link)
    {
        if ($this->listLimit !== null) {
            $link .= '&limit_rows=' . $this->listLimit;
        }

        if ($this->listOffset !== null) {
            $link .= '&limit_offset' . $this->listOffset;
        }

        return $link;
    }
}