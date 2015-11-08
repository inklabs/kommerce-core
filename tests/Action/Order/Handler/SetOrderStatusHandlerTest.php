<?php
namespace inklabs\kommerce\Action\Order\Handler;

use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\tests\Action\Order\Handler\AbstractOrderHandlerTestCase;

class SetOrderStatusHandlerTest extends AbstractOrderHandlerTestCase
{
    public function testExecute()
    {
        $order = $this->dummyData->getOrderFull();
        $order->setStatus(Order::STATUS_PENDING);
        $this->fakeOrderRepository->create($order);

        $handler = new SetOrderStatusHandler($this->orderService);
        $command = new SetOrderStatusCommand($order->getId(), Order::STATUS_SHIPPED);
        $handler->handle($command);

        $this->assertSame(Order::STATUS_SHIPPED, $this->fakeOrderRepository->findOneById(1)->getStatus());
    }
}
