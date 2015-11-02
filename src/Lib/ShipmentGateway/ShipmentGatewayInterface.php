<?php
namespace inklabs\kommerce\Lib\ShipmentGateway;

use inklabs\kommerce\Entity\ShipmentRate;
use inklabs\kommerce\Entity\ShipmentTracker;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\EntityDTO\ParcelDTO;

interface ShipmentGatewayInterface
{
    /**
     * @param OrderAddressDTO $toAddress
     * @param ParcelDTO $parcel
     * @return ShipmentRate[]
     */
    public function getRates(OrderAddressDTO $toAddress, ParcelDTO $parcel);

    /**
     * @param string $shipmentRateExternalId
     * @return ShipmentRate
     */
    public function getShipmentRateByExternalId($shipmentRateExternalId);

    /**
     * @param string $shipmentExternalId
     * @param string $rateExternalId
     * @return ShipmentTracker
     */
    public function buy($shipmentExternalId, $rateExternalId);
}
