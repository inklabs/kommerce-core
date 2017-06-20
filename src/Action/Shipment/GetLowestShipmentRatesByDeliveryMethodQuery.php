<?php
namespace inklabs\kommerce\Action\Shipment;

use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\EntityDTO\ParcelDTO;
use inklabs\kommerce\Lib\Query\QueryInterface;

final class GetLowestShipmentRatesByDeliveryMethodQuery implements QueryInterface
{
    /** @var OrderAddressDTO */
    private $toAddressDTO;

    /** @var ParcelDTO */
    private $parcelDTO;

    public function __construct(OrderAddressDTO $toAddressDTO, ParcelDTO $parcelDTO)
    {
        $this->toAddressDTO = $toAddressDTO;
        $this->parcelDTO = $parcelDTO;
    }

    public function getToAddressDTO(): OrderAddressDTO
    {
        return $this->toAddressDTO;
    }

    public function getParcelDTO(): ParcelDTO
    {
        return $this->parcelDTO;
    }
}
