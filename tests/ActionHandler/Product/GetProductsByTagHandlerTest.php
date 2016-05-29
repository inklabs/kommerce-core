<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\GetProductsByTagQuery;
use inklabs\kommerce\Action\Product\Query\GetProductsByTagRequest;
use inklabs\kommerce\Action\Product\Query\GetProductsByTagResponse;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\ProductDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetProductsByTagHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $pricing = $this->dummyData->getPricing();
        $dtoBuilderFactory = $this->getDTOBuilderFactory();
        $productService = $this->mockService->getProductService();
        $productService->shouldReceive('getProductsByTagId')
            ->andReturn([$this->dummyData->getProduct()])
            ->once();

        $tagIdString = self::UUID_HEX;
        $request = new GetProductsByTagRequest($tagIdString, new PaginationDTO);
        $response = new GetProductsByTagResponse($pricing);

        $handler = new GetProductsByTagHandler($productService, $dtoBuilderFactory);
        $handler->handle(new GetProductsByTagQuery($request, $response));

        $this->assertTrue($response->getProductDTOs()[0] instanceof ProductDTO);
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
