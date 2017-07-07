<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\GetProductAttributesByAttributeValueQuery;
use inklabs\kommerce\ActionResponse\Attribute\GetProductAttributesByAttributeValueResponse;
use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductAttribute;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityDTO\AttributeDTO;
use inklabs\kommerce\EntityDTO\AttributeValueDTO;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\PriceDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetProductAttributesByAttributeValueHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Product::class,
        ProductAttribute::class,
        Tag::class,
        Attribute::class,
        AttributeValue::class,
    ];

    public function testHandle()
    {
        $product1 = $this->dummyData->getProduct();
        $product2 = $this->dummyData->getProduct();
        $product3 = $this->dummyData->getProduct();
        $attribute1 = $this->dummyData->getAttribute();
        $attribute2 = $this->dummyData->getAttribute();
        $attributeValue1 = $this->dummyData->getAttributeValue($attribute1);
        $attributeValue2 = $this->dummyData->getAttributeValue($attribute1);
        $productAttribute1 = $this->dummyData->getProductAttribute($product1, $attributeValue1);
        $productAttribute2 = $this->dummyData->getProductAttribute($product2, $attributeValue1);
        $productAttribute3 = $this->dummyData->getProductAttribute($product3, $attributeValue2);
        $this->persistEntityAndFlushClear([
            $product1,
            $product2,
            $product3,
            $attribute1,
            $attribute2,
            $attributeValue1,
            $attributeValue2,
            $productAttribute1,
            $productAttribute2,
            $productAttribute3,
        ]);
        $query = new GetProductAttributesByAttributeValueQuery(
            $attributeValue1->getId()->getHex(),
            new PaginationDTO()
        );
        $this->setCountLogger();

        /** @var GetProductAttributesByAttributeValueResponse $response */
        $response = $this->dispatchQuery($query);

        $productAttributeDTOs = $response->getProductAttributeDTOs();
        $this->assertEntitiesInDTOList([$productAttribute1, $productAttribute2], $productAttributeDTOs);
        $this->assertTrue($productAttributeDTOs[0]->product->price instanceof PriceDTO);
        $this->assertTrue($productAttributeDTOs[0]->attribute instanceof AttributeDTO);
        $this->assertTrue($productAttributeDTOs[0]->attributeValue instanceof AttributeValueDTO);
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
        $this->assertSame(3, $this->getTotalQueries());
    }
}
