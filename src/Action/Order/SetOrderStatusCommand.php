<?php
namespace inklabs\kommerce\Action\Order;

use inklabs\kommerce\Lib\Command\CommandInterface;
use Ramsey\Uuid\UuidInterface;

final class SetOrderStatusCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $orderId;

    /** @var int */
    private $orderStatusTypeId;

    /**
     * @param UuidInterface $orderId
     * @param int $orderStatusTypeId
     */
    public function __construct(UuidInterface $orderId, $orderStatusTypeId)
    {
        $this->orderId = $orderId;
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
