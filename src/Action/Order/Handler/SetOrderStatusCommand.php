<?php
namespace inklabs\kommerce\Action\Order\Handler;

class SetOrderStatusCommand
{
    /** @var int */
    private $orderId;

    /** @var int */
    private $orderStatus;

    /**
     * @param int $orderStatus
     */
    public function __construct($orderId, $orderStatus)
    {
        $this->orderId = (int) $orderId;
        $this->orderStatus = (int) $orderStatus;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function getOrderStatus()
    {
        return $this->orderStatus;
    }
}
