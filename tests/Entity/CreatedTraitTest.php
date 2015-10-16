<?php
namespace inklabs\kommerce\Entity;

use DateTime;

class CreatedTraitTest extends \PHPUnit_Framework_TestCase
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
