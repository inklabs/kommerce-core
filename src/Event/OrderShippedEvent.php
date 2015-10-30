<?php
namespace inklabs\kommerce\Event;

use inklabs\kommerce\Lib\Event\EventInterface;

class OrderShippedEvent implements EventInterface
{
    /** @var int */
    private $orderId;

    /** @var int */
    private $shipmentId;

    public function __construct($orderId, $shipmentId)
    {
        $this->orderId = (int) $orderId;
        $this->shipmentId = (int) $shipmentId;
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
