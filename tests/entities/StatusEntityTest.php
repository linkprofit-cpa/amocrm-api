<?php

namespace linkprofit\AmoCRM\tests\entities;

use PHPUnit\Framework\TestCase;
use linkprofit\AmoCRM\entities\Status;

class StatusEntityTest extends TestCase
{
    public function testGet()
    {
        $status = new Status();
        $status->name = 'Статус';
        $status->sort = 1;
        $status->color = '#fffeb2';
        $this->assertEquals(['name' => 'Статус', 'sort' => 1, 'color' => '#fffeb2'], $status->get());
    }

    public function testGetWithId()
    {
        $status = new Status();
        $status->name = 'Имя';
        $status->color = '#fffeb2';
        $status->id  = 2;
        $this->assertEquals([2 => ['name' => 'Имя', 'color' => '#fffeb2']], $status->get());
    }

    public function testGetWithSuccessId()
    {
        $status = new Status();
        $status->name = 'Успешно';
        $status->color = 'Поле, которое не должно быть отправлено из-за id = STATUS:SUCCESS';
        $status->id  = Status::SUCCESS;
        $this->assertEquals([142 => ['name' => 'Успешно']], $status->get());
    }
}