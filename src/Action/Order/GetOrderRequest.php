<?php
namespace inklabs\kommerce\Action\Order;

use inklabs\kommerce\Lib\Query\RequestInterface;

class GetOrderRequest implements RequestInterface
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
