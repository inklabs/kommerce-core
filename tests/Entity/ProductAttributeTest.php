<?php
namespace inklabs\kommerce\Entity;

class ProductAttributeTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateAttribute()
    {
        $productAttribute = new ProductAttribute;
        $productAttribute->setProduct(new Product);
        $productAttribute->setAttribute(new Attribute);
        $productAttribute->setAttributeValue(new AttributeValue);

        $this->assertTrue($productAttribute->getProduct() instanceof Product);
        $this->assertTrue($productAttribute->getAttribute() instanceof Attribute);
        $this->assertTrue($productAttribute->getAttributeValue() instanceof AttributeValue);
        $this->assertTrue($productAttribute->getView() instanceof View\ProductAttribute);
    }
}
