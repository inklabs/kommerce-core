<?php
namespace inklabs\kommerce;

class UpdatedTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $mock = $this->getObjectForTrait('inklabs\kommerce\Entity\UpdatedTrait');
        $mock->setUpdated(new \DateTime);
        $mock->preUpdate();
        $this->assertTrue($mock->getUpdated() instanceof \DateTime);
    }

    public function testSetUpdatedWithNull()
    {
        $mock = $this->getObjectForTrait('inklabs\kommerce\Entity\UpdatedTrait');
        $mock->setUpdated();
        $this->assertTrue($mock->getUpdated() instanceof \DateTime);
    }

    public function testGetUpdatedWithNull()
    {
        $mock = $this->getObjectForTrait('inklabs\kommerce\Entity\UpdatedTrait');
        $this->assertSame(null, $mock->getUpdated());
    }
}
