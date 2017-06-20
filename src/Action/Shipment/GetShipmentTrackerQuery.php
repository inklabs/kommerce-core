<?php
namespace inklabs\kommerce\Action\Shipment;

use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetShipmentTrackerQuery implements QueryInterface
{
    /** @var UuidInterface */
    private $shipmentTrackerId;

    public function __construct(string $shipmentTrackerId)
    {
        $this->shipmentTrackerId = Uuid::fromString($shipmentTrackerId);
    }

    public function getShipmentTrackerId(): UuidInterface
    {
        return $this->shipmentTrackerId;
    }
}
