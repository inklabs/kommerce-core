<?php
namespace inklabs\kommerce\Event;

use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Lib\Event\EventInterface;

class OrderCreatedFromCartEvent implements EventInterface
{
    /** @var Order */
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
