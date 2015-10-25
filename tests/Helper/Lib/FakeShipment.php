<?php
namespace inklabs\kommerce\tests\Helper\Lib;

use inklabs\kommerce\Entity\OrderAddress;
use inklabs\kommerce\Entity\Parcel;
use inklabs\kommerce\Entity\ShipmentRate;
use inklabs\kommerce\Lib\Shipping\ShipmentInterface;
use inklabs\kommerce\tests\Helper\Entity\DummyData;

class FakeShipment implements ShipmentInterface
{
    /**
     * @param OrderAddress $fromAddress
     * @param OrderAddress $toAddress
     * @param Parcel $parcel
     * @return ShipmentRate[]
     */
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
