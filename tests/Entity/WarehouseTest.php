<?php
namespace inklabs\kommerce\Entity;

class WarehouseTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $warehouse = new Warehouse;
        $warehouse->setId(1);
        $warehouse->setName('Store Headquarters');
        $warehouse->setAddress(new Address);

        $this->assertEquals(1, $warehouse->getId());
        $this->assertEquals('Store Headquarters', $warehouse->getName());
        $this->assertTrue($warehouse->getAddress() instanceof Address);
    }
}
