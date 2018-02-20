<?php

use PHPUnit\Framework\TestCase;

use linkprofit\AmoCRM\entities\Pipeline;
use linkprofit\AmoCRM\entities\Status;

class PipelineEntityTest extends TestCase
{
    public function testGet()
    {
        $pipeline = $this->pipelineProvider();

        $this->assertEquals(['name' => 'Воронка', 'sort' => 2, 'is_main' => 'on'], $pipeline->get());
    }

    public function testStatusAdd()
    {
        $pipeline = $this->pipelineProvider();

        $status = $this->statusProvider();

        $pipeline->addStatus($status);

        $this->assertEquals(['name' => 'Воронка', 'sort' => 2, 'is_main' => 'on', 'statuses' => [
            $status->get()
        ]], $pipeline->get());
    }

    protected function pipelineProvider()
    {
        $pipeline = new \linkprofit\AmoCRM\entities\Pipeline();
        $pipeline->name = 'Воронка';
        $pipeline->sort = 2;
        $pipeline->is_main = 'on';

        return $pipeline;
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