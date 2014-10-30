<?php
namespace inklabs\kommerce;

class CreatedTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->createdObject = $this->getObjectForTrait('inklabs\kommerce\Entity\Accessor\Created');
    }

    public function testGetCreated()
    {
        $this->assertInstanceOf('DateTime', $this->createdObject->getCreated());
    }

    public function testSetCreated()
    {
        $date = new \DateTime('2014-02-01', new \DateTimeZone('UTC'));
        $this->createdObject->setCreated($date);
        $this->assertEquals($date, $this->createdObject->getCreated());
    }

    public function testSetCreatedWithNull()
    {
        $this->createdObject->setCreated();
        $this->assertInstanceOf('DateTime', $this->createdObject->getCreated());
    }
}
