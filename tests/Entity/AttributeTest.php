<?php
namespace inklabs\kommerce\Entity;

class AttributeTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateAttribute()
    {
        $attribute = new Attribute;
        $attribute->setId(1);
        $attribute->setName('Test Attribute');
        $attribute->setDescription('Test attribute description');
        $attribute->setSortOrder(0);
        $attribute->addAttributeValue(new AttributeValue);
        $attribute->addAttributeValue(new AttributeValue);

        $this->assertEquals(1, $attribute->getId());
        $this->assertEquals('Test Attribute', $attribute->getName());
        $this->assertEquals('Test attribute description', $attribute->getDescription());
        $this->assertEquals(0, $attribute->getSortOrder());
        $this->assertEquals(2, count($attribute->getAttributeValues()));
    }
}
