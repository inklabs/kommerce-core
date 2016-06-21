<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\GetOrdersByUserQuery;
use inklabs\kommerce\Action\Order\Query\GetOrdersByUserRequest;
use inklabs\kommerce\Action\Order\Query\GetOrdersByUserResponse;
use inklabs\kommerce\EntityDTO\OrderDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetOrdersByUserHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $order = $this->dummyData->getOrder();

        $dtoBuilderFactory = $this->getDTOBuilderFactory();
        $orderService = $this->mockService->getOrderService();
        $orderService->shouldReceive('getOrdersByUserId')
            ->andReturn([$order]);

        $request = new GetOrdersByUserRequest(self::UUID_HEX);
        $response = new GetOrdersByUserResponse();
        $handler = new GetOrdersByUserHandler($orderService, $dtoBuilderFactory);

        $handler->handle(new GetOrdersByUserQuery($request, $response));
        $this->assertTrue($response->getOrderDTOs()[0] instanceof OrderDTO);
    }

    public function testHandleWithAllData()
    {
        $order = $this->dummyData->getOrder();

        $dtoBuilderFactory = $this->getDTOBuilderFactory();
        $orderService = $this->mockService->getOrderService();
        $orderService->shouldReceive('getOrdersByUserId')
            ->andReturn([$order]);

        $request = new GetOrdersByUserRequest(self::UUID_HEX);
        $response = new GetOrdersByUserResponse();
        $handler = new GetOrdersByUserHandler($orderService, $dtoBuilderFactory);

        $handler->handle(new GetOrdersByUserQuery($request, $response));
        $this->assertTrue($response->getOrderDTOsWithAllData()[0] instanceof OrderDTO);
    }
}
