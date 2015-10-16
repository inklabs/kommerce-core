<?php
namespace inklabs\kommerce\Entity;

use DateTime;

class TimeTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $mock = $this->getObjectForTrait(TimeTrait::class);
        $this->assertTrue($mock->getCreated() instanceof DateTime);
    }
}
