<?php
namespace inklabs\kommerce\Action\Shipment\Response;

use inklabs\kommerce\EntityDTO\ShipmentRateDTO;

final class GetShipmentRatesResponse implements GetShipmentRatesResponseInterface
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
