<?php
namespace inklabs\kommerce;

class CreatedTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $mock = $this->getObjectForTrait('inklabs\kommerce\Entity\CreatedTrait');
        $mock->setCreated(new \DateTime);
        $this->assertTrue($mock->getCreated() instanceof \DateTime);
    }

    public function testSetCreatedWithNull()
    {
        $mock = $this->getObjectForTrait('inklabs\kommerce\Entity\CreatedTrait');
        $mock->setCreated();
        $this->assertTrue($mock->getCreated() instanceof \DateTime);
    }
}
