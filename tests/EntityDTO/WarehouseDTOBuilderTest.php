<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\Address;
use inklabs\kommerce\Entity\Point;
use inklabs\kommerce\Entity\Warehouse;

class WarehouseDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $address = new Address;
        $address->setPoint(new Point);

        $warehouse = new Warehouse;
        $warehouse->setAddress($address);

        $warehouseDTO = $warehouse->getDTOBuilder()
            ->build();

        $this->assertTrue($warehouseDTO instanceof WarehouseDTO);
        $this->assertTrue($warehouseDTO->address instanceof AddressDTO);
        $this->assertTrue($warehouseDTO->address->point instanceof PointDTO);
    }
}
