<?php

namespace linkprofit\AmoCRM\services;

use linkprofit\AmoCRM\entities\EntityInterface;
use linkprofit\AmoCRM\entities\TaskType;
use linkprofit\AmoCRM\RequestHandler;

/**
 * Class TaskTypeService
 *
 * @package linkprofit\AmoCRM\services
 */
class TaskTypeService extends BaseService
{
    /**
     * TaskTypeService constructor.
     *
     * @param RequestHandler $requestHandler
     */
    public function __construct(RequestHandler $requestHandler)
    {
        parent::__construct($requestHandler);
    }

    /**
     * @var TaskType[]
     */
    protected $entities = [];

    /**
     * @param $array
     *
     * @return EntityInterface
     */
    public function parseArrayToEntity($array)
    {
        $taskType = new TaskType();
        $taskType->set($array);

        return $taskType;
    }

    /**
     * @return string
     */
    protected function getLink()
    {
        return 'https://' . $this->request->getSubdomain() . '.amocrm.ru/private/tasks/ajax_task_status_edit.php';
    }

    /**
     * @param \linkprofit\AmoCRM\entities\EntityInterface $taskType
     *
     * @return mixed
     */
    public function add(EntityInterface $taskType)
    {
        if ($taskType instanceof TaskType) {
            $this->entities[] = $taskType;
        }
    }

    /**
     * @return bool|mixed
     */
    public function save()
    {
        $this->composeFields();
        $this->request->performRequest($this->getLink(), $this->fields, 'application/x-www-form-urlencoded');
        $this->response = $this->request->getResponse();

        if ($this->checkResponse()) {
            return $this->getResponse();
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

        $this->fields['ACTION'] = 'ALL_EDIT';

        if (count($addFields)) {
            $this->fields['task_types'] = $addFields;
        }

        if (count($updateFields)) {
            $this->fields['task_types'] = $updateFields;
        }
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

        foreach ($this->response['data'] as $item) {
            $this->entities[] = $this->parseArrayToEntity($item);
        }

        return $this->entities;
    }

    /**
     * @return bool
     */
    protected function checkResponse()
    {
        if (isset($this->response['status']) && $this->response['status'] === 'OK' && count($this->response['data'])) {
            return true;
        }

        return false;
    }
}