<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\GetProductsByTagQuery;
use inklabs\kommerce\ActionResponse\Product\GetProductsByTagResponse;
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
        $query = new GetProductsByTagQuery(
            $tag->getId()->getHex(),
            new PaginationDTO()
        );

        /** @var GetProductsByTagResponse $response */
        $response = $this->dispatchQuery($query);

        $this->assertEquals($product->getId(), $response->getProductDTOs()[0]->id);
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
