<?php
namespace inklabs\kommerce\tests\Lib\ShipmentGateway;

use inklabs\kommerce\Entity\ShipmentRate;
use inklabs\kommerce\Entity\ShipmentTracker;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\EntityDTO\ParcelDTO;
use inklabs\kommerce\tests\Helper\TestCase\KommerceTestCase;
use inklabs\kommerce\tests\Helper\Lib\ShipmentGateway\FakeShipmentGateway;

class ShipmentGatewayInterfaceTest extends KommerceTestCase
{
    public function testCreate()
    {
        $fromAddress = new OrderAddressDTO();
        $toAddress = new OrderAddressDTO();
        $parcel = new ParcelDTO();

        $shipment = new FakeShipmentGateway($fromAddress);
        $rates = $shipment->getRates(
            $toAddress,
            $parcel
        );

        $this->assertTrue($rates[0] instanceof ShipmentRate);
    }

    public function testBuy()
    {
        $shipmentExternalId = self::SHIPMENT_RATE_EXTERNAL_ID;
        $rateExternalId = self::RATE_EXTERNAL_ID;

        $shipmentGateway = new FakeShipmentGateway(new OrderAddressDTO);
        $shipment = $shipmentGateway->buy($shipmentExternalId, $rateExternalId);

        $this->assertTrue($shipment instanceof ShipmentTracker);
    }
}
