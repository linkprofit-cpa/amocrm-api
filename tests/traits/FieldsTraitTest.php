<?php

use PHPUnit\Framework\TestCase;
use linkprofit\AmoCRM\traits\FieldsTrait;

class FieldsTraitTest extends TestCase
{
    public $field1;
    public $field2;
    public $field3;

    protected $fieldsList = ['field1', 'field2', 'field3'];

    use FieldsTrait;

    public function testOnlyExistedFieldsFilling()
    {
        $this->field2 = 'two';
        $this->fieldsList[] = 'field4';
        $this->assertEquals(['field2' => 'two'], $this->getExistedValues($this->fieldsList));
    }

    public function testFieldsFilling()
    {
        $this->field1 = 1;
        $this->field2 = 'two';
        $this->field3 = 3.0;
        $this->assertEquals(['field1' => 1, 'field2' => 'two', 'field3' => 3.0], $this->getExistedValues($this->fieldsList));
    }

    public function testNullValuesDissalowedAndIntegerAllowed()
    {
        $this->field1 = NULL;
        $this->field2 = 0;
        $this->field3 = 1;
        $this->assertEquals(['field2' => 0, 'field3' => 1], $this->getExistedValues($this->fieldsList));
    }
}