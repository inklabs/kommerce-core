<?php
namespace inklabs\kommerce;

class UpdatedTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->updatedObject = $this->getObjectForTrait('inklabs\kommerce\Entity\Accessor\Updated');
    }

    public function testGetUpdatedWithNull()
    {
        $this->assertSame(null, $this->updatedObject->getUpdated());
    }

    public function testSetUpdated()
    {
        $date = new \DateTime('2014-02-01', new \DateTimeZone('UTC'));
        $this->updatedObject->setUpdated($date);
        $this->assertEquals($date, $this->updatedObject->getUpdated());
    }

    public function testSetUpdatedWithNull()
    {
        $this->updatedObject->setUpdated();
        $this->assertInstanceOf('DateTime', $this->updatedObject->getUpdated());
    }
}
