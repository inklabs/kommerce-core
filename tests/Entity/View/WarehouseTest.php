<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class WarehouseTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityWarehouse = new Entity\Warehouse;
        $entityWarehouse->setAddress(new Entity\Address);

        $warehouse = $entityWarehouse->getView();

        $this->assertTrue($warehouse instanceof Warehouse);
        $this->assertTrue($warehouse->address instanceof Address);
    }
}
