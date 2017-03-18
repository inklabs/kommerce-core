<?php
namespace inklabs\kommerce\Action\Shipment;

use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetShipmentTrackerQuery implements QueryInterface
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
