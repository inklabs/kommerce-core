<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class ProductAttributeTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityProductAttribute = new Entity\ProductAttribute;
        $entityProductAttribute->setProduct(new Entity\Product);
        $entityProductAttribute->setAttribute(new Entity\Attribute);
        $entityProductAttribute->setAttributeValue(new Entity\AttributeValue);

        $productAttribute = $entityProductAttribute->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($productAttribute instanceof ProductAttribute);
        $this->assertTrue($productAttribute->product instanceof Product);
        $this->assertTrue($productAttribute->attribute instanceof Attribute);
        $this->assertTrue($productAttribute->attributeValue instanceof AttributeValue);
    }
}
