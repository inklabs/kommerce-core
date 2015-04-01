<?php
namespace inklabs\kommerce\Entity\Accessor;

class TimeTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $mock = $this->getObjectForTrait('inklabs\kommerce\Entity\Accessor\Time');
        $this->assertTrue($mock->getCreated() instanceof \DateTime);
    }
}
