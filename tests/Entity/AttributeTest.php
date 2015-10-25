<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class AttributeTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $attribute = new Attribute;
        $attribute->setName('Test Attribute');
        $attribute->setDescription('Test attribute description');
        $attribute->setSortOrder(0);
        $attribute->addAttributeValue(new AttributeValue);
        $attribute->addProductAttribute(new ProductAttribute);

        $this->assertEntityValid($attribute);
        $this->assertSame('Test Attribute', $attribute->getName());
        $this->assertSame('Test attribute description', $attribute->getDescription());
        $this->assertSame(0, $attribute->getSortOrder());
        $this->assertTrue($attribute->getAttributeValues()[0] instanceof AttributeValue);
        $this->assertTrue($attribute->getProductAttributes()[0] instanceof ProductAttribute);
    }
}
