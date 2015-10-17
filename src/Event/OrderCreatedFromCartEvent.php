<?php
namespace inklabs\kommerce\Event;

use inklabs\kommerce\Lib\Event\EventInterface;

class OrderCreatedFromCartEvent implements EventInterface
{
    /** @var int */
    private $orderId;

    /**
     * @param int $orderId
     */
    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }
}
