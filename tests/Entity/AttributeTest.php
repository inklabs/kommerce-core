<?php
namespace inklabs\kommerce\Entity;

class AttributeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->attribute = new Attribute;
        $this->attribute->setName('Test Attribute');
        $this->attribute->setDescription('Test attribute description');
        $this->attribute->setSortOrder(0);
    }

    public function testGetters()
    {
        $this->assertEquals(null, $this->attribute->getId());
        $this->assertEquals('Test Attribute', $this->attribute->getName());
        $this->assertEquals('Test attribute description', $this->attribute->getDescription());
        $this->assertEquals(0, $this->attribute->getSortOrder());
    }

    public function testWithAttributeValues()
    {
        $this->attribute = new Attribute;
        $this->attribute->setName('Color');

        $this->attributeValueRed = new AttributeValue;
        $this->attributeValueRed->setSku('RED');
        $this->attributeValueRed->setName('Red');

        $this->attributeValueGreen = new AttributeValue;
        $this->attributeValueGreen->setSku('GRN');
        $this->attributeValueGreen->setName('Green');

        $this->attributeValueBlue = new AttributeValue;
        $this->attributeValueBlue->setSku('BLU');
        $this->attributeValueBlue->setName('Blue');

        $this->attribute->addAttributeValue($this->attributeValueRed);
        $this->attribute->addAttributeValue($this->attributeValueGreen);
        $this->attribute->addAttributeValue($this->attributeValueBlue);

        $this->assertEquals('Color', $this->attribute->getName());
    }
}
