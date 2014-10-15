<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeValue;

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

        $this->attribute_value_red = new AttributeValue;
        $this->attribute_value_red->setSku('RED');
        $this->attribute_value_red->setName('Red');

        $this->attribute_value_green = new AttributeValue;
        $this->attribute_value_green->setSku('GRN');
        $this->attribute_value_green->setName('Green');

        $this->attribute_value_blue = new AttributeValue;
        $this->attribute_value_blue->setSku('BLU');
        $this->attribute_value_blue->setName('Blue');

        $this->attribute->addAttributeValue($this->attribute_value_red);
        $this->attribute->addAttributeValue($this->attribute_value_green);
        $this->attribute->addAttributeValue($this->attribute_value_blue);

        $this->assertEquals('Color', $this->attribute->getName());
    }
}
