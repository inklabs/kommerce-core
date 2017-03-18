<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\ListProductsQuery;
use inklabs\kommerce\ActionResponse\Product\ListProductsResponse;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ListProductsHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Product::class,
        Tag::class,
    ];

    public function testHandle()
    {
        $product1 = $this->dummyData->getProduct();
        $product2 = $this->dummyData->getProduct();
        $this->persistEntityAndFlushClear([
            $product1,
            $product2,
        ]);
        $queryString = 'product';
        $query = new ListProductsQuery($queryString, new PaginationDTO());

        /** @var ListProductsResponse $response */
        $response = $this->dispatchQuery($query);

        $this->assertEntitiesInDTOList([$product1, $product2], $response->getProductDTOs());
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
