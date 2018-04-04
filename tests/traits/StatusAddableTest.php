<?php

namespace linkprofit\AmoCRM\tests\traits;

use PHPUnit\Framework\TestCase;
use linkprofit\AmoCRM\traits\StatusAddable;

class StatusAddableTest extends TestCase
{
    use StatusAddable;

    public function testAdd()
    {
        $status = $this->statusProvider();
        $this->addStatus($status);

        $this->assertEquals([$status], $this->statuses);
    }

    protected function statusProvider()
    {
        $status = new \linkprofit\AmoCRM\entities\Status();
        $status->name = 'Статус';
        $status->sort = 1;
        $status->color = '#fffeb2';

        return $status;
    }
}