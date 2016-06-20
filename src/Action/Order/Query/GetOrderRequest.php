<?php
namespace inklabs\kommerce\Action\Order\Query;

use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetOrderRequest
{
    /** @var UuidInterface */
    private $orderId;

    /**
     * @param string $orderId
     */
    public function __construct($orderId)
    {
        $this->orderId = Uuid::fromString($orderId);
    }

    public function getOrderId()
    {
        return $this->orderId;
    }
}
