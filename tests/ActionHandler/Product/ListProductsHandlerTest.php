<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\ListProductsQuery;
use inklabs\kommerce\Action\Product\Query\ListProductsRequest;
use inklabs\kommerce\Action\Product\Query\ListProductsResponse;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\ProductDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ListProductsHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $productService = $this->mockService->getProductService();
        $dtoBuilderFactory = $this->getDTOBuilderFactory();

        $queryString = 'product';
        $request = new ListProductsRequest($queryString, new PaginationDTO);
        $response = new ListProductsResponse();

        $handler = new ListProductsHandler($productService, $dtoBuilderFactory);
        $handler->handle(new ListProductsQuery($request, $response));

        $this->assertTrue($response->getProductDTOs()[0] instanceof ProductDTO);
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
