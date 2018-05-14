<?php

namespace linkprofit\AmoCRM\tests\providers;


class CatalogElementProvider
{
    public function getElement()
    {
        $element = new \linkprofit\AmoCRM\entities\CatalogElement();
        $element->catalog_id = 1924000;
        $element->name = 'Элемент каталога';

        return $element;
    }
}