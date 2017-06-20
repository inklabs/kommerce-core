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

    public function __construct(string $orderId, int $orderStatusTypeId)
    {
        $this->orderId = Uuid::fromString($orderId);
        $this->orderStatusTypeId = $orderStatusTypeId;
    }

    public function getOrderId(): UuidInterface
    {
        return $this->orderId;
    }

    public function getOrderStatusTypeId(): int
    {
        return $this->orderStatusTypeId;
    }
}
