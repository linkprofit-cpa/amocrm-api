<?php

namespace linkprofit\AmoCRM\tests\providers;


class StatusProvider
{
    public function getStatus()
    {
        $status = new \linkprofit\AmoCRM\entities\Status();
        $status->name = 'Статус';
        $status->sort = 1;
        $status->color = '#fffeb2';

        return $status;
    }
}