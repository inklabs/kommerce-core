<?php
namespace inklabs\kommerce\Action\Shipment\Response;

use inklabs\kommerce\EntityDTO\ShipmentRateDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

interface GetShipmentRatesResponseInterface extends ResponseInterface
{
    public function addShipmentRateDTO(ShipmentRateDTO $shipmentRateDTO);
}
