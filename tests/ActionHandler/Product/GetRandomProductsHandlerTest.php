<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\GetRandomProductsQuery;
use inklabs\kommerce\ActionResponse\Product\GetRandomProductsResponse;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetRandomProductsHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Product::class,
        Tag::class,
    ];

    public function testHandle()
    {
        $product = $this->dummyData->getProduct();
        $this->persistEntityAndFlushClear($product);
        $limit = 4;
        $query = new GetRandomProductsQuery($limit);

        /** @var GetRandomProductsResponse $response */
        $response = $this->dispatchQuery($query);

        $this->assertEquals($product->getId(), $response->getProductDTOs()[0]->id);
    }
}
