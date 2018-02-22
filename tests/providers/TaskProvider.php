<?php

namespace linkprofit\AmoCRM\tests\providers;


class TaskProvider
{
    public function getTask()
    {
        $task = new \linkprofit\AmoCRM\entities\Task();
        $task->text = 'Задача';

        $nextDayTimestamp = strtotime('+1 day');
        $task->complete_till_at = $nextDayTimestamp;

        $task->task_type = $task::CALL_TASK_TYPE;
        $task->responsible_user_id = 1924000;

        return $task;
    }
}