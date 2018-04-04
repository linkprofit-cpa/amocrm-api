<?php

namespace linkprofit\AmoCRM\tests\entities;

use PHPUnit\Framework\TestCase;

use linkprofit\AmoCRM\tests\providers\StatusProvider;
use linkprofit\AmoCRM\tests\providers\PipelineProvider;

class PipelineEntityTest extends TestCase
{
    /**
     * @var StatusProvider
     */
    protected $pipelineStatus;

    /**
     * @var PipelineProvider
     */
    protected $pipeline;

    public function testGet()
    {
        $pipeline = $this->pipeline->getPipeline();

        $this->assertEquals(['name' => 'Воронка', 'sort' => 2, 'is_main' => 'on'], $pipeline->get());
    }

    public function testStatusAdd()
    {
        $pipeline = $this->pipeline->getPipeline();
        $status = $this->pipelineStatus->getStatus();

        $pipeline->addStatus($status);

        $this->assertEquals(['name' => 'Воронка', 'sort' => 2, 'is_main' => 'on', 'statuses' => [
            $status->get()
        ]], $pipeline->get());
    }

    protected function setUp()
    {
       $this->pipeline = new PipelineProvider();
       $this->pipelineStatus = new StatusProvider();
    }
}