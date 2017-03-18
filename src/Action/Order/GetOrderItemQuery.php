<?php
namespace inklabs\kommerce\Action\Order;

use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetOrderItemQuery implements QueryInterface
{
    /** @var UuidInterface */
    private $orderItemId;

    /**
     * @param string $orderItemId
     */
    public function __construct($orderItemId)
    {
        $this->orderItemId = Uuid::fromString($orderItemId);
    }

    public function getOrderItemId()
    {
        return $this->orderItemId;
    }
}
