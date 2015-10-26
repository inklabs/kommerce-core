<?php
namespace inklabs\kommerce\tests\Lib\ShipmentGateway;

use inklabs\kommerce\Entity\ShipmentRate;
use inklabs\kommerce\Entity\ShipmentTracker;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use inklabs\kommerce\tests\Helper\Lib\ShipmentGateway\FakeShipmentGateway;

class ShipmentGatewayInterfaceTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $fromAddress = $this->dummyData->getOrderAddress();
        $toAddress = $this->dummyData->getOrderAddress();
        $parcel = $this->dummyData->getParcel();

        $shipment = new FakeShipmentGateway;
        $rates = $shipment->getRates(
            $fromAddress,
            $toAddress,
            $parcel
        );

        $this->assertTrue($rates[0] instanceof ShipmentRate);
    }

    public function testBuy()
    {
        $shipmentExternalId = 'shp_xxxxxxxxx';
        $rateExternalId = 'rate_xxxxxxxxx';

        $shipmentGateway = new FakeShipmentGateway;
        $shipment = $shipmentGateway->buy($shipmentExternalId, $rateExternalId);

        $this->assertTrue($shipment instanceof ShipmentTracker);
    }
}
