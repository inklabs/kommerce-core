<?php
namespace inklabs\kommerce\Entity;

use DateTime;

class UpdatedTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $mock = $this->getObjectForTrait(UpdatedTrait::class);
        $mock->setUpdated(new DateTime);
        $mock->preUpdate();
        $this->assertTrue($mock->getUpdated() instanceof DateTime);
    }

    public function testSetUpdatedWithNull()
    {
        $mock = $this->getObjectForTrait(UpdatedTrait::class);
        $mock->setUpdated();
        $this->assertTrue($mock->getUpdated() instanceof DateTime);
    }

    public function testGetUpdatedWithNull()
    {
        $mock = $this->getObjectForTrait(UpdatedTrait::class);
        $this->assertSame(null, $mock->getUpdated());
    }
}
