<?php
namespace inklabs\kommerce\Action\Order;

use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetOrderQuery implements QueryInterface
{
    /** @var UuidInterface */
    private $orderId;

    public function __construct(string $orderId)
    {
        $this->orderId = Uuid::fromString($orderId);
    }

    public function getOrderId(): UuidInterface
    {
        return $this->orderId;
    }
}
