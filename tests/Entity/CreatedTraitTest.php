<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class CreatedTraitTest extends EntityTestCase
{
    public function testCreate()
    {
        $mock = $this->getObjectForTrait(CreatedTrait::class);
        $mock->setCreated(new DateTime);
        $this->assertTrue($mock->getCreated() instanceof DateTime);
    }

    public function testSetCreatedWithNull()
    {
        $mock = $this->getObjectForTrait(CreatedTrait::class);
        $mock->setCreated();
        $this->assertTrue($mock->getCreated() instanceof DateTime);
    }
}
