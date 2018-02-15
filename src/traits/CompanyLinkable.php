<?php

namespace linkprofit\AmoCRM\traits;

/**
 * Class CompanyLinkable
 * @package linkprofit\AmoCRM\traits
 */
trait CompanyLinkable
{
    /**
     * @var integer Уникальный идентификатор компании
     */
    public $company_id;

    /**
     * @param $id
     */
    public function linkCompanyById($id)
    {
        $this->company_id = $id;
    }
}