<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\SetOrderStatusCommand;
use inklabs\kommerce\Entity\OrderStatusType;
use inklabs\kommerce\Service\OrderServiceInterface;

final class SetOrderStatusHandler
{
    /** @var OrderServiceInterface */
    private $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function handle(SetOrderStatusCommand $command)
    {
        $this->orderService->setOrderStatus(
            $command->getOrderId(),
            OrderStatusType::createById($command->getOrderStatusTypeId())
        );
    }
}
