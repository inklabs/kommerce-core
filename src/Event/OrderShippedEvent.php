<?php
namespace inklabs\kommerce\Event;

use inklabs\kommerce\Lib\Event\EventInterface;
use inklabs\kommerce\Lib\UuidInterface;

class OrderShippedEvent implements EventInterface
{
    /** @var UuidInterface */
    private $orderId;

    /** @var UuidInterface */
    private $shipmentId;

    public function __construct(UuidInterface $orderId, UuidInterface $shipmentId)
    {
        $this->orderId = $orderId;
        $this->shipmentId = $shipmentId;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function getShipmentId()
    {
        return $this->shipmentId;
    }
}
