<?php
namespace inklabs\kommerce\Action\Order;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class SetOrderStatusCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $orderId;

    /** @var int */
    private $orderStatusTypeId;

    /**
     * @param string $orderId
     * @param int $orderStatusTypeId
     */
    public function __construct($orderId, $orderStatusTypeId)
    {
        $this->orderId = Uuid::fromString($orderId);
        $this->orderStatusTypeId = (int) $orderStatusTypeId;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function getOrderStatusTypeId()
    {
        return $this->orderStatusTypeId;
    }
}
