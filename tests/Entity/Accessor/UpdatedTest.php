<?php
namespace inklabs\kommerce;

class UpdatedTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $mock = $this->getObjectForTrait('inklabs\kommerce\Entity\Accessor\Updated');
        $mock->setUpdated(new \DateTime);
        $this->assertTrue($mock->getUpdated() instanceof \DateTime);
    }

    public function testSetUpdatedWithNull()
    {
        $mock = $this->getObjectForTrait('inklabs\kommerce\Entity\Accessor\Updated');
        $mock->setUpdated();
        $this->assertTrue($mock->getUpdated() instanceof \DateTime);
    }

    public function testGetUpdatedWithNull()
    {
        $mock = $this->getObjectForTrait('inklabs\kommerce\Entity\Accessor\Updated');
        $this->assertSame(null, $mock->getUpdated());
    }
}
