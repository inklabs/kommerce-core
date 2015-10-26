<?php
namespace inklabs\kommerce\tests\Lib\ShipmentGateway;

use inklabs\kommerce\Entity\ShipmentRate;
use inklabs\kommerce\Entity\ShipmentTracker;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use inklabs\kommerce\tests\Helper\Lib\ShipmentGateway\FakeShipmentGateway;

class ShipmentGatewayInterfaceTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $fromAddress = $this->dummyData->getOrderAddress()->getDTOBuilder()->build();
        $toAddress = $this->dummyData->getOrderAddress()->getDTOBuilder()->build();
        $parcel = $this->dummyData->getParcel()->getDTOBuilder()->build();

        $shipment = new FakeShipmentGateway($fromAddress);
        $rates = $shipment->getRates(
            $toAddress,
            $parcel
        );

        $this->assertTrue($rates[0] instanceof ShipmentRate);
    }

    public function testBuy()
    {
        $shipmentExternalId = 'shp_xxxxxxxxx';
        $rateExternalId = 'rate_xxxxxxxxx';

        $shipmentGateway = new FakeShipmentGateway(new OrderAddressDTO);
        $shipment = $shipmentGateway->buy($shipmentExternalId, $rateExternalId);

        $this->assertTrue($shipment instanceof ShipmentTracker);
    }
}
