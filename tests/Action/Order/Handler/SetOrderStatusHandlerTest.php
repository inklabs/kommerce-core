<?php
namespace inklabs\kommerce\Action\Order\Handler;

use inklabs\kommerce\Action\Order\SetOrderStatusCommand;
use inklabs\kommerce\Entity\OrderStatusType;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class SetOrderStatusHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $orderService = $this->mockService->getOrderService();
        $orderService->shouldReceive('setOrderStatus')
            ->once();

        $command = new SetOrderStatusCommand(1, OrderStatusType::SHIPPED);
        $handler = new SetOrderStatusHandler($orderService);
        $handler->handle($command);
    }
}
