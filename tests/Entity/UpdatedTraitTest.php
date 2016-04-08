<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class UpdatedTraitTest extends EntityTestCase
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
