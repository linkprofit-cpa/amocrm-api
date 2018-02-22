<?php

namespace linkprofit\AmoCRM\services;

use linkprofit\AmoCRM\entities\EntityInterface;
use linkprofit\AmoCRM\entities\Task;

/**
 * Class TaskService
 * @package linkprofit\AmoCRM\services
 */
class TaskService extends BaseService
{
    /**
     * @var Task[]
     */
    protected $entities = [];

    /**
     * @param Task $task
     */
    public function add(EntityInterface $task)
    {
        if ($task instanceof Task) {
            $this->entities[] = $task;
        }
    }

    /**
     * @param $array
     * @return Task
     */
    public function parseArrayToEntity($array)
    {
        $task = new Task();
        $task->set($array);

        return $task;
    }

    /**
     * @return string
     */
    protected function getLink()
    {
        return 'https://' . $this->request->getSubdomain() . '.amocrm.ru/api/v2/tasks';
    }

}