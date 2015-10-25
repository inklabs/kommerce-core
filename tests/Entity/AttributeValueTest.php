<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class AttributeValueTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $attributeValue = new AttributeValue;
        $attributeValue->setSku('TA');
        $attributeValue->setName('Test Attribute');
        $attributeValue->setDescription('Test attribute description');
        $attributeValue->setSortOrder(0);
        $attributeValue->setAttribute(new Attribute);
        $attributeValue->addProductAttribute(new ProductAttribute);

        $this->assertEntityValid($attributeValue);
        $this->assertSame('TA', $attributeValue->getSku());
        $this->assertSame('Test Attribute', $attributeValue->getName());
        $this->assertSame('Test attribute description', $attributeValue->getDescription());
        $this->assertSame(0, $attributeValue->getSortOrder());
        $this->assertTrue($attributeValue->getAttribute() instanceof Attribute);
        $this->assertTrue($attributeValue->getProductAttributes()[0] instanceof ProductAttribute);
    }
}
