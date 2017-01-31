<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\GetProductsByTagQuery;
use inklabs\kommerce\Action\Product\Query\GetProductsByTagRequest;
use inklabs\kommerce\Action\Product\Query\GetProductsByTagResponse;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetProductsByTagHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Product::class,
        Tag::class,
    ];

    public function testHandle()
    {
        $product = $this->dummyData->getProduct();
        $tag = $this->dummyData->getTag();
        $product->addTag($tag);
        $this->persistEntityAndFlushClear([$product, $tag]);
        $request = new GetProductsByTagRequest($tag->getId()->getHex(), new PaginationDTO());
        $response = new GetProductsByTagResponse($this->getPricing());
        $query = new GetProductsByTagQuery($request, $response);

        $this->dispatchQuery($query);

        $this->assertEquals($product->getId(), $response->getProductDTOs()[0]->id);
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
