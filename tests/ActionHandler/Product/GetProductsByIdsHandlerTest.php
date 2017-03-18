<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\GetProductsByIdsQuery;
use inklabs\kommerce\ActionResponse\Product\GetProductsByIdsResponse;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetProductsByIdsHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Product::class,
        Tag::class,
    ];

    public function testHandle()
    {
        $product = $this->dummyData->getProduct();
        $this->persistEntityAndFlushClear($product);
        $query = new GetProductsByIdsQuery([$product->getId()->getHex()]);

        /** @var GetProductsByIdsResponse $response */
        $response = $this->dispatchQuery($query);

        $this->assertEquals($product->getId(), $response->getProductDTOs()[0]->id);
    }
}
