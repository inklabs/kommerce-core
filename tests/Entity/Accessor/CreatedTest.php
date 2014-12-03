<?php
namespace inklabs\kommerce;

class CreatedTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $mock = $this->getObjectForTrait('inklabs\kommerce\Entity\Accessor\Created');
        $mock->setCreated(new \DateTime);
        $this->assertInstanceOf('DateTime', $mock->getCreated());
    }

    public function testSetCreatedWithNull()
    {
        $mock = $this->getObjectForTrait('inklabs\kommerce\Entity\Accessor\Created');
        $mock->setCreated();
        $this->assertInstanceOf('DateTime', $mock->getCreated());
    }
}
