<?php
namespace inklabs\kommerce\Entity;

class OrderCreatedFromCartEvent
{
    /** @var Order */
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
