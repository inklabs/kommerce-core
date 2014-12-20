<?php
namespace inklabs\kommerce;

class CreatedTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $mock = $this->getObjectForTrait('inklabs\kommerce\Entity\Accessor\Created');
        $mock->setCreated(new \DateTime);
        $this->assertTrue($mock->getCreated() instanceof \DateTime);
    }

    public function testSetCreatedWithNull()
    {
        $mock = $this->getObjectForTrait('inklabs\kommerce\Entity\Accessor\Created');
        $mock->setCreated();
        $this->assertTrue($mock->getCreated() instanceof \DateTime);
    }
}
