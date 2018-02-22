<?php

namespace linkprofit\AmoCRM\tests\traits;

use PHPUnit\Framework\TestCase;
use linkprofit\AmoCRM\traits\CompanyLinkable;

class CompanyLinkableTest extends TestCase
{
    use CompanyLinkable;

    public function testLink()
    {
        $this->linkCompanyById(1);
        $this->assertEquals('1', $this->company_id);
    }
}