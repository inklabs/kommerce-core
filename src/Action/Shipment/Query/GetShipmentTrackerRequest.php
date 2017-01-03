<?php
namespace inklabs\kommerce\Action\Shipment\Query;

use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetShipmentTrackerRequest
{
    /** @var UuidInterface */
    private $shipmentTrackerId;

    /**
     * @param string $shipmentTrackerId
     */
    public function __construct($shipmentTrackerId)
    {
        $this->shipmentTrackerId = Uuid::fromString($shipmentTrackerId);
    }

    public function getShipmentTrackerId()
    {
        return $this->shipmentTrackerId;
    }
}
