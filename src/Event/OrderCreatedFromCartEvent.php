<?php
namespace inklabs\kommerce\Event;

use inklabs\kommerce\Lib\Event\EventInterface;
use inklabs\kommerce\Lib\UuidInterface;

class OrderCreatedFromCartEvent implements EventInterface
{
    /** @var UuidInterface */
    private $orderId;

    public function __construct(UuidInterface $orderId)
    {
        $this->orderId = $orderId;
    }

    public function getOrderId(): UuidInterface
    {
        return $this->orderId;
    }
}
