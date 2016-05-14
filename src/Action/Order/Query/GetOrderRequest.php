<?php
namespace inklabs\kommerce\Action\Order\Query;

final class GetOrderRequest
{
    /** @var int */
    private $orderId;

    /**
     * @param int $orderId
     */
    public function __construct($orderId)
    {
        $this->orderId = (int) $orderId;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }
}
