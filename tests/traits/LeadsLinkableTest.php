<?php

namespace linkprofit\AmoCRM\tests\traits;

use PHPUnit\Framework\TestCase;
use linkprofit\AmoCRM\traits\LeadsLinkable;

class LeadsLinkableTest extends TestCase
{
    use LeadsLinkable;

    public function testLink()
    {
        $this->linkLeadById(1);
        $this->assertEquals('1', $this->leads_id);
    }

    public function testPluralLink()
    {
        $this->leads_id = false;

        $this->linkLeadById(2);
        $this->linkLeadById(3);
        $this->assertEquals('2,3', $this->leads_id);
    }
}