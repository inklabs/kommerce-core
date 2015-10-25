<?php
namespace inklabs\kommerce\tests\Lib\Shipping;

use inklabs\kommerce\Entity\ShipmentRate;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use inklabs\kommerce\tests\Helper\Lib\FakeShipment;

class ShipmentInterfaceTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $fromAddress = $this->dummyData->getOrderAddress();
        $toAddress = $this->dummyData->getOrderAddress();
        $parcel = $this->dummyData->getParcel();

        $shipment = new FakeShipment;
        $rates = $shipment->getRates(
            $fromAddress,
            $toAddress,
            $parcel
        );

        $this->assertTrue($rates[0] instanceof ShipmentRate);
    }
}
