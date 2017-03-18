<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\GetProductQuery;
use inklabs\kommerce\Action\Product\Query\GetProductRequest;
use inklabs\kommerce\ActionResponse\Product\GetProductResponse;
use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductAttribute;
use inklabs\kommerce\Entity\ProductQuantityDiscount;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetProductHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Attribute::class,
        AttributeValue::class,
        Image::class,
        Option::class,
        OptionProduct::class,
        Product::class,
        ProductAttribute::class,
        ProductQuantityDiscount::class,
        Tag::class,
    ];

    public function testHandle()
    {
        $product = $this->dummyData->getProduct();
        $this->persistEntityAndFlushClear($product);
        $query = new GetProductQuery($product->getId()->getHex());

        /** @var GetProductResponse $response */
        $response = $this->dispatchQuery($query);
        $this->assertEquals($product->getId(), $response->getProductDTO()->id);

        $response = $this->dispatchQuery($query);
        $this->assertEquals($product->getId(), $response->getProductDTOWithAllData()->id);
    }
}
