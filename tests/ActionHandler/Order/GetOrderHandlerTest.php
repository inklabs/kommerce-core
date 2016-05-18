<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\GetOrderQuery;
use inklabs\kommerce\Action\Order\Query\GetOrderRequest;
use inklabs\kommerce\Action\Order\Query\GetOrderResponse;
use inklabs\kommerce\EntityDTO\OrderDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetOrderHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $orderService = $this->mockService->getOrderService();

        $request = new GetOrderRequest(99);
        $response = new GetOrderResponse;

        $handler = new GetOrderHandler($orderService);
        $handler->handle(new GetOrderQuery($request, $response));

        $this->assertTrue($response->getOrderDTO() instanceof OrderDTO);
    }
}
