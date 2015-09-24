<?php
namespace inklabs\kommerce\Entity;

class TimeTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $mock = $this->getObjectForTrait('inklabs\kommerce\Entity\TimeTrait');
        $this->assertTrue($mock->getCreated() instanceof \DateTime);
    }
}
