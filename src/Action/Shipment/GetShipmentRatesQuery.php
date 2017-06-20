<?php
namespace inklabs\kommerce\Action\Shipment;

use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\EntityDTO\ParcelDTO;
use inklabs\kommerce\Lib\Query\QueryInterface;

final class GetShipmentRatesQuery implements QueryInterface
{
    /** @var OrderAddressDTO */
    private $toAddressDTO;

    /** @var ParcelDTO */
    private $parcelDTO;

    /** @var OrderAddressDTO */
    private $fromAddressDTO;

    public function __construct(
        OrderAddressDTO $toAddressDTO,
        ParcelDTO $parcelDTO,
        OrderAddressDTO $fromAddressDTO = null
    ) {
        $this->toAddressDTO = $toAddressDTO;
        $this->parcelDTO = $parcelDTO;
        $this->fromAddressDTO = $fromAddressDTO;
    }

    public function getToAddressDTO(): OrderAddressDTO
    {
        return $this->toAddressDTO;
    }

    public function getParcelDTO(): ParcelDTO
    {
        return $this->parcelDTO;
    }

    public function getFromAddressDTO(): OrderAddressDTO
    {
        return $this->fromAddressDTO;
    }
}
