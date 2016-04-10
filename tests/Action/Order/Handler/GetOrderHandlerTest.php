<?php
namespace inklabs\kommerce\Action\Order\Handler;

use inklabs\kommerce\Action\Order\GetOrderRequest;
use inklabs\kommerce\Action\Order\Response\GetOrderResponse;
use inklabs\kommerce\EntityDTO\OrderDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetOrderHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $orderService = $this->mockService->getOrderService();

        $request = new GetOrderRequest(1);
        $response = new GetOrderResponse;

        $handler = new GetOrderHandler($orderService);
        $handler->handle($request, $response);

        $this->assertTrue($response->getOrderDTO() instanceof OrderDTO);
    }
}
