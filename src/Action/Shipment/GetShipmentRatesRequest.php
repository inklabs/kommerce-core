<?php
namespace inklabs\kommerce\Action\Shipment;

use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\EntityDTO\ParcelDTO;
use inklabs\kommerce\Lib\Query\RequestInterface;

class GetShipmentRatesRequest implements RequestInterface
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

    public function getToAddressDTO()
    {
        return $this->toAddressDTO;
    }

    public function getParcelDTO()
    {
        return $this->parcelDTO;
    }
}
