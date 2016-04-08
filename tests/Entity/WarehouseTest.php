<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class WarehouseTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $warehouse = new Warehouse;

        $this->assertSame(null, $warehouse->getName());
        $this->assertSame(null, $warehouse->getAddress());
    }

    public function testCreate()
    {
        $address = $this->dummyData->getAddress();

        $warehouse = new Warehouse;
        $warehouse->setName('Store Headquarters');
        $warehouse->setAddress($address);

        $this->assertEntityValid($warehouse);
        $this->assertSame('Store Headquarters', $warehouse->getName());
        $this->assertSame($address, $warehouse->getAddress());
    }
}
