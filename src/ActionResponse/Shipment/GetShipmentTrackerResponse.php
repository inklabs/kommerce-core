<?php
namespace inklabs\kommerce\ActionResponse\Shipment;

use inklabs\kommerce\EntityDTO\Builder\ShipmentTrackerDTOBuilder;

class GetShipmentTrackerResponse
{
    /** @var ShipmentTrackerDTOBuilder */
    protected $shipmentTrackerDTOBuilder;

    public function getShipmentTrackerDTO()
    {
        return $this->shipmentTrackerDTOBuilder
            ->build();
    }

    public function setShipmentTrackerDTOBuilder(ShipmentTrackerDTOBuilder $shipmentTrackerDTOBuilder)
    {
        $this->shipmentTrackerDTOBuilder = $shipmentTrackerDTOBuilder;
    }
}
