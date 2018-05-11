<?php

namespace linkprofit\AmoCRM\tests\entities;

use linkprofit\AmoCRM\entities\Catalog;
use linkprofit\AmoCRM\tests\providers\CatalogProvider;
use PHPUnit\Framework\TestCase;

class CatalogEnitityTest extends TestCase
{
    /**
     * @var \linkprofit\AmoCRM\tests\providers\CatalogProvider
     */
    protected $catalog;

    public function testGet()
    {
        $catalog = $this->catalog->getCatalog();
        $this->assertEquals([
            'name'               => 'Список товаров',
            'type'               => Catalog::CATALOG_TYPE_REGULAR,
            'can_add_elements'   => true,
            'can_show_in_cards'  => true,
            'can_link_multiple' => true,
        ], $catalog->get());
    }

    public function testGetWithId()
    {
        $task = $this->catalog->getCatalog();
        $task->id = 2;
        $taskArray = $task->get();
        $this->assertEquals([
            'id'                => 2,
            'name'              => 'Список товаров',
            'type'              => Catalog::CATALOG_TYPE_REGULAR,
            'can_add_elements'  => true,
            'can_show_in_cards' => true,
            'can_link_multiple' => true,
        ], $taskArray);
    }

    protected function setUp()
    {
       $this->catalog = new CatalogProvider();
    }
}