<?php
namespace inklabs\kommerce\Action\Shipment\Response;

use inklabs\kommerce\EntityDTO\ShipmentRateDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

class GetShipmentRatesResponse implements ResponseInterface
{
    /** @var ShipmentRateDTO[] */
    private $shipmentRatesDTO = [];

    public function addShipmentRateDTO(ShipmentRateDTO $shipmentRateDTO)
    {
        $this->shipmentRatesDTO[] = $shipmentRateDTO;
    }

    public function getShipmentRatesDTO()
    {
        return $this->shipmentRatesDTO;
    }
}
