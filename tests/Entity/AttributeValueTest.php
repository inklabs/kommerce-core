<?php
namespace inklabs\kommerce\Entity;

class AttributeValueTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateAttributeValue()
    {
        $attributeValue = new AttributeValue;
        $attributeValue->setSku('TA');
        $attributeValue->setName('Test Attribute');
        $attributeValue->setDescription('Test attribute description');
        $attributeValue->setSortOrder(0);

        $this->assertSame('TA', $attributeValue->getSku());
        $this->assertSame('Test Attribute', $attributeValue->getName());
        $this->assertSame('Test attribute description', $attributeValue->getDescription());
        $this->assertSame(0, $attributeValue->getSortOrder());
        $this->assertTrue($attributeValue->getView() instanceof View\AttributeValue);
    }
}
