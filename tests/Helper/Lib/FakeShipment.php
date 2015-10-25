<?php
namespace inklabs\kommerce\tests\Helper\Lib;

use inklabs\kommerce\Lib\Shipping\ShipmentInterface;
use inklabs\kommerce\tests\Helper\Entity\DummyData;

class FakeShipment implements ShipmentInterface
{
    public function getRates($fromAddress, $toAddress, $parcel)
    {
        $dummyData = new DummyData;

        return [
            $dummyData->getShipmentRate(225),
            $dummyData->getShipmentRate(775),
            $dummyData->getShipmentRate(1195),
        ];
    }
}
