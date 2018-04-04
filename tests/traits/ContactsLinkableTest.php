<?php

namespace linkprofit\AmoCRM\tests\traits;

use PHPUnit\Framework\TestCase;
use linkprofit\AmoCRM\traits\ContactsLinkable;

class ContactsLinkableTest extends TestCase
{
    use ContactsLinkable;

    public function testLink()
    {
        $this->linkContactById(1);
        $this->assertEquals('1', $this->contacts_id);
    }

    public function testPluralLink()
    {
        $this->contacts_id = false;

        $this->linkContactById(2);
        $this->linkContactById(3);
        $this->assertEquals('2,3', $this->contacts_id);
    }
}