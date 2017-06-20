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
    public function getRates(OrderAddressDTO $toAddress, ParcelDTO $parcel, OrderAddressDTO $fromAddress = null): array;

    /**
     * @param OrderAddressDTO $toAddress
     * @param ParcelDTO $parcel
     * @return ShipmentRate[]
     */
    public function getTrimmedRates(OrderAddressDTO $toAddress, ParcelDTO $parcel): array;

    public function getShipmentRateByExternalId(string $shipmentRateExternalId): ShipmentRate;

    public function buy(string $shipmentExternalId, string $rateExternalId, UuidInterface $id = null): ShipmentTracker;
}
