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
     * @param string $link
     *
     * @return string
     */
    public function addIdToLink($link)
    {
        if ($this->listId !== null) {
            $link .= '&id' . $this->listId;
        }

        return $link;
    }
}