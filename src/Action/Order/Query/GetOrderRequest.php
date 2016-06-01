<?php
namespace inklabs\kommerce\Action\Order\Query;

use inklabs\kommerce\Lib\UuidInterface;

final class GetOrderRequest
{
    /** @var UuidInterface */
    private $orderId;

    public function __construct(UuidInterface $orderId)
    {
        $this->orderId = $orderId;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }
}
