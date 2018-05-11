<?php

namespace linkprofit\AmoCRM\tests\providers;


class TaskTypeProvider
{
    public function getTaskType()
    {
        $taskType = new \linkprofit\AmoCRM\entities\TaskType();
        $taskType->name = 'Тип задачи';

        return $taskType;
    }
}