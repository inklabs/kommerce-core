<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\GetRelatedProductsQuery;
use inklabs\kommerce\Action\Product\Query\GetRelatedProductsRequest;
use inklabs\kommerce\Action\Product\Query\GetRelatedProductsResponse;
use inklabs\kommerce\EntityDTO\ProductDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetRelatedProductsHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $pricing = $this->dummyData->getPricing();
        $productService = $this->mockService->getProductService();
        $dtoBuilderFactory = $this->getDTOBuilderFactory();

        $limit = 4;
        $productIds = [
            self::UUID_HEX
        ];

        $request = new GetRelatedProductsRequest($productIds, $limit);
        $response = new GetRelatedProductsResponse($pricing);

        $handler = new GetRelatedProductsHandler($productService, $dtoBuilderFactory);
        $handler->handle(new GetRelatedProductsQuery($request, $response));

        $this->assertTrue($response->getProductDTOs()[0] instanceof ProductDTO);
    }
}
