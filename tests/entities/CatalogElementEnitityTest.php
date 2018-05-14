<?php

namespace linkprofit\AmoCRM\tests\entities;

use linkprofit\AmoCRM\tests\providers\CatalogElementProvider;
use linkprofit\AmoCRM\tests\providers\CustomFieldProvider;
use PHPUnit\Framework\TestCase;

class CatalogElementEnitityTest extends TestCase
{
    /**
     * @var CatalogElementProvider
     */
    protected $element;

    /**
     * @var CustomFieldProvider
     */
    protected $customField;

    public function testGet()
    {
        $element = $this->element->getElement();

        $this->assertEquals([
            'name'       => 'Элемент каталога',
            'catalog_id' => 1924000,
        ], $element->get());
    }

    public function testGetWithId()
    {
        $element = $this->element->getElement();
        $element->id = 2;
        $leadArray = $element->get();
        $this->assertEquals([
            'id'         => 2,
            'name'       => 'Элемент каталога',
            'catalog_id' => 1924000,
        ], $leadArray);
    }

    public function testCustomFieldAdd()
    {
        $element = $this->element->getElement();

        $customField = $this->customField->getEmailField();
        $element->addCustomField($customField);

        $this->assertEquals([
            'name'          => 'Элемент каталога',
            'catalog_id'    => 1924000,
            'custom_fields' => [
                $customField->get(),
            ],
        ], $element->get());
    }

    protected function setUp()
    {
       $this->element = new CatalogElementProvider();
       $this->customField = new CustomFieldProvider();
    }
}