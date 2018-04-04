<?php

namespace linkprofit\AmoCRM\tests\providers;


class PipelineProvider
{
    public function getPipeline()
    {
        $pipeline = new \linkprofit\AmoCRM\entities\Pipeline();
        $pipeline->name = 'Воронка';
        $pipeline->sort = 2;
        $pipeline->is_main = 'on';

        return $pipeline;
    }
}