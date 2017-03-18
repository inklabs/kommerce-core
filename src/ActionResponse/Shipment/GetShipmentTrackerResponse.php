<?php
namespace inklabs\kommerce\ActionResponse\Shipment;

use inklabs\kommerce\EntityDTO\Builder\ShipmentTrackerDTOBuilder;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetShipmentTrackerResponse implements ResponseInterface
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
