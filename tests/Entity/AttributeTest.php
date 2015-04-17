<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\View;

class AttributeTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateAttribute()
    {
        $attribute = new Attribute;
        $attribute->setName('Test Attribute');
        $attribute->setDescription('Test attribute description');
        $attribute->setSortOrder(0);
        $attribute->addAttributeValue(new AttributeValue);
        $attribute->addProductAttribute(new ProductAttribute);

        $this->assertSame('Test Attribute', $attribute->getName());
        $this->assertSame('Test attribute description', $attribute->getDescription());
        $this->assertSame(0, $attribute->getSortOrder());
        $this->assertTrue($attribute->getAttributeValues()[0] instanceof AttributeValue);
        $this->assertTrue($attribute->getProductAttributes()[0] instanceof ProductAttribute);
        $this->assertTrue($attribute->getView() instanceof View\Attribute);
    }
}
