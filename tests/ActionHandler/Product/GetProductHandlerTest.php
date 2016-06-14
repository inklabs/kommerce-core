<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\GetProductQuery;
use inklabs\kommerce\Action\Product\Query\GetProductRequest;
use inklabs\kommerce\Action\Product\Query\GetProductResponse;
use inklabs\kommerce\EntityDTO\ProductDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetProductHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $pricing = $this->dummyData->getPricing();
        $productService = $this->mockService->getProductService();
        $dtoBuilderFactory = $this->getDTOBuilderFactory();

        $request = new GetProductRequest(self::UUID_HEX);
        $response = new GetProductResponse($pricing);

        $handler = new GetProductHandler($productService, $dtoBuilderFactory);

        $handler->handle(new GetProductQuery($request, $response));
        $this->assertTrue($response->getProductDTO() instanceof ProductDTO);

        $handler->handle(new GetProductQuery($request, $response));
        $this->assertTrue($response->getProductDTOWithAllData() instanceof ProductDTO);
    }
}
