<?php
namespace inklabs\kommerce\Action\Order\Handler;

use inklabs\kommerce\Action\Order\GetOrderRequest;
use inklabs\kommerce\Action\Order\Response\GetOrderResponse;
use inklabs\kommerce\EntityDTO\OrderDTO;
use inklabs\kommerce\Service\OrderServiceInterface;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetOrderHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $order = $this->dummyData->getOrder();

        $orderService = $this->getMockeryMock(OrderServiceInterface::class);
        $orderService->shouldReceive('findOneById')
            ->andReturn(
                $order
            );
        /** @var OrderServiceInterface $orderService */

        $request = new GetOrderRequest($order->getid());
        $response = new GetOrderResponse;

        $handler = new GetOrderHandler($orderService);
        $handler->handle($request, $response);

        $this->assertTrue($response->getOrderDTO() instanceof OrderDTO);
    }
}
