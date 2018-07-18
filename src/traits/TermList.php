<?php

namespace linkprofit\AmoCRM\traits;

/**
 * Trait TermList
 * @package linkprofit\AmoCRM\traits
 */
trait TermList
{
    /**
     * @var int
     */
    protected $listTerm;

    /**
     * @param $term
     *
     * @return $this
     */
    public function setTerm($term)
    {
        $this->listTerm = $term;

        return $this;
    }

    /**
     * @param array $query
     *
     * @return array
     */
    public function addTermToQuery($query = [])
    {
        if ($this->listTerm !== null) {
            $query['query'] = $this->listTerm;
        }

        return $query;
    }
}