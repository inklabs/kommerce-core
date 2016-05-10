<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class ProductAttributeTest extends EntityTestCase
{
    public function testCreate()
    {
        $product = $this->dummyData->getProduct();
        $attribute = $this->dummyData->getAttribute();
        $attributeValue = $this->dummyData->getAttributeValue();

        $productAttribute = new ProductAttribute($product, $attribute, $attributeValue);

        $this->assertSame($product, $productAttribute->getProduct());
        $this->assertSame($attribute, $productAttribute->getAttribute());
        $this->assertSame($attributeValue, $productAttribute->getAttributeValue());
    }
}
