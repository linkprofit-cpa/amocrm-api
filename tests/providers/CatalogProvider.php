<?php

namespace linkprofit\AmoCRM\tests\providers;


class CatalogProvider
{
    public function getCatalog()
    {
        $catalog = new \linkprofit\AmoCRM\entities\Catalog();
        $catalog->name = 'Список товаров';

        return $catalog;
    }
}