<?php
namespace inklabs\kommerce\Lib\ShipmentGateway;

use inklabs\kommerce\Entity\ShipmentRate;
use inklabs\kommerce\Entity\ShipmentTracker;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\EntityDTO\ParcelDTO;
use inklabs\kommerce\Lib\UuidInterface;

interface ShipmentGatewayInterface
{
    /**
     * @param OrderAddressDTO $toAddress
     * @param ParcelDTO $parcel
     * @param null|OrderAddressDTO $fromAddress
     * @return ShipmentRate[]
     */
    public function getRates(OrderAddressDTO $toAddress, ParcelDTO $parcel, OrderAddressDTO $fromAddress = null);

    /**
     * @param OrderAddressDTO $toAddress
     * @param ParcelDTO $parcel
     * @return ShipmentRate[]
     */
    public function getTrimmedRates(OrderAddressDTO $toAddress, ParcelDTO $parcel);

    /**
     * @param string $shipmentRateExternalId
     * @return ShipmentRate
     */
    public function getShipmentRateByExternalId($shipmentRateExternalId);

    /**
     * @param string $shipmentExternalId
     * @param string $rateExternalId
     * @param null|UuidInterface $id
     * @return ShipmentTracker
     */
    public function buy($shipmentExternalId, $rateExternalId, UuidInterface $id = null);
}
