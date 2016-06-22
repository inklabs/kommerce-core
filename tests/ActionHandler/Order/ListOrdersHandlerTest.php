<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\ListOrdersQuery;
use inklabs\kommerce\Action\Order\Query\ListOrdersRequest;
use inklabs\kommerce\Action\Order\Query\ListOrdersResponse;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\OrderDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ListOrdersHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $tagService = $this->mockService->getOrderService();
        $dtoBuilderFactory = $this->getDTOBuilderFactory();

        $queryString = 'order';
        $request = new ListOrdersRequest($queryString, new PaginationDTO);
        $response = new ListOrdersResponse();

        $handler = new ListOrdersHandler($tagService, $dtoBuilderFactory);
        $handler->handle(new ListOrdersQuery($request, $response));

        $this->assertTrue($response->getOrderDTOs()[0] instanceof OrderDTO);
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
