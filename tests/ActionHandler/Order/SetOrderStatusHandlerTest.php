<?php
namespace inklabs\kommerce\ActionHandler\Order;

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

        $order = $this->dummyData->getOrder();

        $command = new SetOrderStatusCommand($order->getid(), OrderStatusType::SHIPPED);
        $handler = new SetOrderStatusHandler($orderService);
        $handler->handle($command);
    }
}
