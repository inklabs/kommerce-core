<?php
namespace inklabs\kommerce\Action\Order\Handler;

use inklabs\kommerce\Action\Order\GetOrderRequest;
use inklabs\kommerce\Action\Order\Response\GetOrderResponse;
use inklabs\kommerce\EntityDTO\OrderDTO;
use inklabs\kommerce\tests\Action\Order\Handler\AbstractOrderHandlerTestCase;

class GetOrderHandlerTest extends AbstractOrderHandlerTestCase
{
    public function testExecute()
    {
        $order = $this->dummyData->getOrderFull();
        $this->fakeOrderRepository->create($order);

        $getOrderHandler = new GetOrderHandler($this->orderService);
        $response = new GetOrderResponse;
        $getOrderHandler->handle(new GetOrderRequest($order->getid()), $response);

        $this->assertTrue($response->getOrderDTO() instanceof OrderDTO);
    }
}
