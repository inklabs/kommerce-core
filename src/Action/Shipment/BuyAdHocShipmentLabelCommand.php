<?php
namespace inklabs\kommerce\Action\Shipment;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class BuyAdHocShipmentLabelCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $shipmentTrackerId;

    /** @var string */
    private $shipmentExternalId;

    /** @var string */
    private $rateExternalId;

    public function __construct(string $shipmentExternalId, string $rateExternalId)
    {
        $this->shipmentTrackerId = Uuid::uuid4();
        $this->shipmentExternalId = $shipmentExternalId;
        $this->rateExternalId = $rateExternalId;
    }

    public function getShipmentTrackerId(): UuidInterface
    {
        return $this->shipmentTrackerId;
    }

    public function getShipmentExternalId(): string
    {
        return $this->shipmentExternalId;
    }

    public function getRateExternalId(): string
    {
        return $this->rateExternalId;
    }
}
