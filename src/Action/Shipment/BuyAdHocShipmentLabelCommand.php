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

    /**
     * @param string $shipmentExternalId
     * @param string $rateExternalId
     */
    public function __construct(
        $shipmentExternalId,
        $rateExternalId
    ) {
        $this->shipmentTrackerId = Uuid::uuid4();
        $this->shipmentExternalId = (string) $shipmentExternalId;
        $this->rateExternalId = (string) $rateExternalId;
    }

    public function getShipmentTrackerId()
    {
        return $this->shipmentTrackerId;
    }

    public function getShipmentExternalId()
    {
        return $this->shipmentExternalId;
    }

    public function getRateExternalId()
    {
        return $this->rateExternalId;
    }
}
