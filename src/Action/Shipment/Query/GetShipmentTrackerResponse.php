<?php
namespace inklabs\kommerce\Action\Shipment\Query;

use inklabs\kommerce\EntityDTO\Builder\ShipmentTrackerDTOBuilder;

class GetShipmentTrackerResponse implements GetShipmentTrackerResponseInterface
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
