<?php
namespace inklabs\kommerce\Entity;

class AttributeValueTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateAttributeValue()
    {
        $attributeValue = new AttributeValue;
        $attributeValue->setId(1);
        $attributeValue->setSku('TA');
        $attributeValue->setName('Test Attribute');
        $attributeValue->setDescription('Test attribute description');
        $attributeValue->setSortOrder(0);

        $this->assertEquals(1, $attributeValue->getId());
        $this->assertEquals('TA', $attributeValue->getSku());
        $this->assertEquals('Test Attribute', $attributeValue->getName());
        $this->assertEquals('Test attribute description', $attributeValue->getDescription());
        $this->assertEquals(0, $attributeValue->getSortOrder());
    }
}
