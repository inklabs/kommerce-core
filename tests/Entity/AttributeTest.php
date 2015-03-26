<?php
namespace inklabs\kommerce\Entity;

class AttributeTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateAttribute()
    {
        $attribute = new Attribute;
        $attribute->setName('Test Attribute');
        $attribute->setDescription('Test attribute description');
        $attribute->setSortOrder(0);
        $attribute->addAttributeValue(new AttributeValue);
        $attribute->addAttributeValue(new AttributeValue);

        $this->assertSame('Test Attribute', $attribute->getName());
        $this->assertSame('Test attribute description', $attribute->getDescription());
        $this->assertSame(0, $attribute->getSortOrder());
        $this->assertSame(2, count($attribute->getAttributeValues()));
        $this->assertTrue($attribute->getView() instanceof View\Attribute);
    }
}
