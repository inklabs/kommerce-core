<?php
namespace inklabs\kommerce\Action\Order;

use inklabs\kommerce\Lib\Command\CommandInterface;

final class SetOrderStatusCommand implements CommandInterface
{
    /** @var int */
    private $orderId;

    /** @var int */
    private $orderStatusTypeId;

    /**
     * @param int $orderId
     * @param int $orderStatusTypeId
     */
    public function __construct($orderId, $orderStatusTypeId)
    {
        $this->orderId = (int) $orderId;
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
