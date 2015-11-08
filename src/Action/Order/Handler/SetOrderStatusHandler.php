<?php
namespace inklabs\kommerce\Action\Order\Handler;

use inklabs\kommerce\Action\Order\SetOrderStatusCommand;
use inklabs\kommerce\Service\OrderServiceInterface;

class SetOrderStatusHandler
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
            $command->getOrderStatus()
        );
    }
}
