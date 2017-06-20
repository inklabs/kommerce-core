<?php
namespace inklabs\kommerce\ActionResponse\Shipment;

use inklabs\kommerce\EntityDTO\Builder\ShipmentTrackerDTOBuilder;
use inklabs\kommerce\EntityDTO\ShipmentTrackerDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetShipmentTrackerResponse implements ResponseInterface
{
    /** @var ShipmentTrackerDTOBuilder */
    protected $shipmentTrackerDTOBuilder;

    public function setShipmentTrackerDTOBuilder(ShipmentTrackerDTOBuilder $shipmentTrackerDTOBuilder): void
    {
        $this->shipmentTrackerDTOBuilder = $shipmentTrackerDTOBuilder;
    }

    public function getShipmentTrackerDTO(): ShipmentTrackerDTO
    {
        return $this->shipmentTrackerDTOBuilder
            ->build();
    }
}
