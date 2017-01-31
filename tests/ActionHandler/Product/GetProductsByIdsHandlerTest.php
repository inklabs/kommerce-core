<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\GetProductsByIdsQuery;
use inklabs\kommerce\Action\Product\Query\GetProductsByIdsRequest;
use inklabs\kommerce\Action\Product\Query\GetProductsByIdsResponse;
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
        $request = new GetProductsByIdsRequest([$product->getId()->getHex(),]);
        $response = new GetProductsByIdsResponse($this->getPricing());
        $query = new GetProductsByIdsQuery($request, $response);

        $this->dispatchQuery($query);

        $this->assertEquals($product->getId(), $response->getProductDTOs()[0]->id);
    }
}
