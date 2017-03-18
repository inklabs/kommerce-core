<?php
namespace inklabs\kommerce\Action\Order;

use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetOrderQuery implements QueryInterface
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
