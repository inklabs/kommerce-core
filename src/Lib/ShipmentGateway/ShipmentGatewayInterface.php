<?php
namespace inklabs\kommerce\Lib\ShipmentGateway;

use inklabs\kommerce\Entity\OrderAddress;
use inklabs\kommerce\Entity\Parcel;
use inklabs\kommerce\Entity\ShipmentRate;

interface ShipmentGatewayInterface
{
    /**
     * @param OrderAddress $fromAddress
     * @param OrderAddress $toAddress
     * @param Parcel $parcel
     * @return ShipmentRate[]
     */
    public function getRates($fromAddress, $toAddress, $parcel);

    /**
     * @param string $shipmentExternalId
     * @param string $rateExternalId
     * @return ShipmentTracker
     */
    public function buy($shipmentExternalId, $rateExternalId);
}
