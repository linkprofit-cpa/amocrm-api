<?php

namespace linkprofit\AmoCRM\services;

use linkprofit\AmoCRM\entities\EntityInterface;
use linkprofit\AmoCRM\RequestHandler;

/**
 * Class BaseService
 * @package linkprofit\AmoCRM\services
 */
abstract class BaseService implements ServiceInterface, ListableService
{
    /**
     * @var RequestHandler
     */
    protected $request;

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var mixed
     */
    protected $response;

    /**
     * @var array EntityInterface
     */
    protected $entities = [];

    /**
     * LeadService constructor.
     * @param RequestHandler $requestHandler
     */
    public function __construct(RequestHandler $requestHandler)
    {
        $this->request = $requestHandler;
    }

    /**
     * @return bool|mixed
     */
    public function save()
    {
        $this->composeFields();
        $this->request->performRequest($this->getLink(), $this->fields);
        $this->response = $this->request->getResponse();

        if ($this->checkResponse()) {
            return $this->getResponse();
        }

        return false;
    }

    /**
     * @return array|bool
     */
    public function getList()
    {
        $link = $this->composeListLink($this->getLink());

        $this->request->performRequest($link, [], 'application/json', 'GET');
        $this->response = $this->request->getResponse();

        return $this->parseResponseToEntities();
    }

    /**
     * @param $link
     *
     * @return mixed
     */
    protected function composeListLink($link)
    {
        return $link;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return array
     */
    public function getEntities()
    {
        return $this->entities;
    }

    /**
     * @return array|bool
     */
    public function parseResponseToEntities()
    {
        if (!$this->checkResponse()) {
            return false;
        }
        $this->entities = [];

        foreach ($this->response['_embedded']['items'] as $item) {
            $this->entities[] = $this->parseArrayToEntity($item);
        }

        return $this->entities;
    }

    /**
     * @param $array
     * @return EntityInterface
     */
    abstract public function parseArrayToEntity($array);

    /**
     * @return bool
     */
    protected function checkResponse()
    {
        if (isset($this->response['_embedded']['items']) && count($this->response['_embedded']['items'])) {
            return true;
        }

        return false;
    }

    /**
     * Fill fields for save request
     */
    protected function composeFields()
    {
        $addFields = [];
        $updateFields = [];

        foreach ($this->entities as $entity) {
            if ($entity->id) {
                $updateFields[] = $entity->get();
            } else {
                $addFields[] = $entity->get();
            }
        }

        if (count($addFields)) {
            $this->fields['add'] = $addFields;
        }

        if (count($updateFields)) {
            $this->fields['update'] = $updateFields;
        }
    }

    /**
     * @return string
     */
    abstract protected function getLink();
}