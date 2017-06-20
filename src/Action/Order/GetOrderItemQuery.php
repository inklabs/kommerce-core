<?php
namespace inklabs\kommerce\Action\Order;

use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetOrderItemQuery implements QueryInterface
{
    /** @var UuidInterface */
    private $orderItemId;

    public function __construct(string $orderItemId)
    {
        $this->orderItemId = Uuid::fromString($orderItemId);
    }

    public function getOrderItemId(): UuidInterface
    {
        return $this->orderItemId;
    }
}
