<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\GetRandomProductsQuery;
use inklabs\kommerce\Action\Product\Query\GetRandomProductsRequest;
use inklabs\kommerce\Action\Product\Query\GetRandomProductsResponse;
use inklabs\kommerce\EntityDTO\ProductDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetRandomProductsHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $pricing = $this->dummyData->getPricing();
        $dtoBuilderFactory = $this->getDTOBuilderFactory();
        $productService = $this->mockService->getProductService();
        $productService->shouldReceive('getRandomProducts')
            ->andReturn([$this->dummyData->getProduct()])
            ->once();

        $limit = 4;
        $request = new GetRandomProductsRequest($limit);
        $response = new GetRandomProductsResponse($pricing);

        $handler = new GetRandomProductsHandler($productService, $dtoBuilderFactory);
        $handler->handle(new GetRandomProductsQuery($request, $response));

        $this->assertTrue($response->getProductDTOs()[0] instanceof ProductDTO);
    }
}
