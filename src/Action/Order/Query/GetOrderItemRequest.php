<?php
namespace inklabs\kommerce\Action\Order\Query;

use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetOrderItemRequest
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
