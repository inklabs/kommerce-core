<?php
namespace inklabs\kommerce\tests\Helper\Lib;

use DateTime;
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

        $shipmentRate1 = $dummyData->getShipmentRate(225);
        $shipmentRate1->setDeliveryDays(7);

        $shipmentRate2 = $dummyData->getShipmentRate(775);
        $shipmentRate2->setDeliveryDays(3);

        $shipmentRate3 = $dummyData->getShipmentRate(1195);
        $shipmentRate3->setDeliveryDays(2);
        $shipmentRate3->setDeliveryDate(new DateTime('+2 days'));
        $shipmentRate3->setIsDeliveryDateGuaranteed(true);

        return [
            $shipmentRate1,
            $shipmentRate2,
            $shipmentRate3,
        ];
    }
}
