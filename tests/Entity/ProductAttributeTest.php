<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class ProductAttributeTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $productAttribute = new ProductAttribute;

        $this->assertSame(null, $productAttribute->getProduct());
        $this->assertSame(null, $productAttribute->getAttribute());
        $this->assertSame(null, $productAttribute->getAttributeValue());
    }

    public function testCreate()
    {
        $product = $this->dummyData->getProduct();
        $attribute = $this->dummyData->getAttribute();
        $attributeValue = $this->dummyData->getAttributeValue();

        $productAttribute = new ProductAttribute;
        $productAttribute->setProduct($product);
        $productAttribute->setAttribute($attribute);
        $productAttribute->setAttributeValue($attributeValue);

        $this->assertSame($product, $productAttribute->getProduct());
        $this->assertSame($attribute, $productAttribute->getAttribute());
        $this->assertSame($attributeValue, $productAttribute->getAttributeValue());
    }
}
