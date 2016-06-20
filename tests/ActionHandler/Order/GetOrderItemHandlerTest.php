<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\GetOrderItemQuery;
use inklabs\kommerce\Action\Order\Query\GetOrderItemRequest;
use inklabs\kommerce\Action\Order\Query\GetOrderItemResponse;
use inklabs\kommerce\EntityDTO\OrderItemDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetOrderItemHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $orderItem = $this->dummyData->getOrderItem();
        $order = $this->dummyData->getOrder(null, [$orderItem]);

        $dtoBuilderFactory = $this->getDTOBuilderFactory();
        $orderService = $this->mockService->getOrderService();
        $orderService->shouldReceive('getOrderItemById')
            ->with($orderItem->getId())
            ->andReturn($orderItem)
            ->twice();

        $request = new GetOrderItemRequest($orderItem->getId()->getHex());
        $response = new GetOrderItemResponse;
        $handler = new GetOrderItemHandler($orderService, $dtoBuilderFactory);

        $handler->handle(new GetOrderItemQuery($request, $response));
        $this->assertTrue($response->getOrderItemDTO() instanceof OrderItemDTO);

        $handler->handle(new GetOrderItemQuery($request, $response));
        $this->assertTrue($response->getOrderItemDTOWithAllData() instanceof OrderItemDTO);
    }
}
