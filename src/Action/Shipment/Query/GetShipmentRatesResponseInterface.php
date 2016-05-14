<?php
namespace inklabs\kommerce\Action\Shipment\Query;

use inklabs\kommerce\EntityDTO\ShipmentRateDTO;

interface GetShipmentRatesResponseInterface
{
    public function addShipmentRateDTO(ShipmentRateDTO $shipmentRateDTO);
}
