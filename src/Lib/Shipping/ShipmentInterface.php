<?php
namespace inklabs\kommerce\Lib\Shipping;

use inklabs\kommerce\Entity\OrderAddress;
use inklabs\kommerce\Entity\Parcel;
use inklabs\kommerce\Entity\ShipmentRate;

interface ShipmentInterface
{
    /**
     * @param OrderAddress $fromAddress
     * @param OrderAddress $toAddress
     * @param Parcel $parcel
     * @return ShipmentRate[]
     */
    public function getRates($fromAddress, $toAddress, $parcel);
}
