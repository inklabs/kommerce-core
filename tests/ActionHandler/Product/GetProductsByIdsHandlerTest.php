<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\GetProductsByIdsQuery;
use inklabs\kommerce\Action\Product\Query\GetProductsByIdsRequest;
use inklabs\kommerce\Action\Product\Query\GetProductsByIdsResponse;
use inklabs\kommerce\EntityDTO\ProductDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetProductsByIdsHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $pricing = $this->dummyData->getPricing();
        $product = $this->dummyData->getProduct();

        $productIds = [
            $product->getId()->getHex(),
        ];

        $dtoBuilderFactory = $this->getDTOBuilderFactory();
        $productService = $this->mockService->getProductService();
        $productService->shouldReceive('getProductsByIds')
            ->with([$product->getId()])
            ->andReturn([$product]);

        $request = new GetProductsByIdsRequest($productIds);
        $response = new GetProductsByIdsResponse($pricing);

        $handler = new GetProductsByIdsHandler($productService, $dtoBuilderFactory);
        $handler->handle(new GetProductsByIdsQuery($request, $response));

        $this->assertTrue($response->getProductDTOs()[0] instanceof ProductDTO);
    }
}
