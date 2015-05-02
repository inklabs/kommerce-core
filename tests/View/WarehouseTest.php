<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;

class WarehouseTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityWarehouse = new Entity\Warehouse;
        $entityWarehouse->setAddress(new Entity\Address);

        $warehouse = $entityWarehouse->getView()
            ->export();

        $this->assertTrue($warehouse instanceof Warehouse);
        $this->assertTrue($warehouse->address instanceof Address);
    }
}
