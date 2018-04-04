<?php

namespace linkprofit\AmoCRM\tests\traits;

use PHPUnit\Framework\TestCase;
use linkprofit\AmoCRM\traits\FieldsMergeable;

class FieldsMergeableTest extends TestCase
{
    public $mergedField;

    use FieldsMergeable;

    public function testSetMergedField()
    {
        $this->mergeStringToField(1, 'mergedField');
        $this->assertEquals('1', $this->mergedField);

        $this->mergeStringToField(2, 'mergedField');
        $this->assertEquals('1,2', $this->mergedField);
    }
}