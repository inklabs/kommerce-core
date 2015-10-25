<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class WarehouseTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $address = new Address;
        $address->setAttention('John Doe');
        $address->setAddress1('123 Any St');
        $address->setCity('Santa Monica');
        $address->setState('CA');
        $address->setZip5('90401');
        $address->setPoint(new Point);

        $warehouse = new Warehouse;
        $warehouse->setName('Store Headquarters');
        $warehouse->setAddress($address);

        $this->assertEntityValid($warehouse);
        $this->assertSame('Store Headquarters', $warehouse->getName());
        $this->assertTrue($warehouse->getAddress() instanceof Address);
    }
}
