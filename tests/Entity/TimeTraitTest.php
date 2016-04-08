<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class TimeTraitTest extends EntityTestCase
{
    public function testCreate()
    {
        $mock = $this->getObjectForTrait(TimeTrait::class);
        $this->assertTrue($mock->getCreated() instanceof DateTime);
    }
}
