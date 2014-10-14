<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeValue;

class AttributeTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $attribute = new Attribute;
        $attribute->setName('Test Attribute');
        $attribute->setDescription('Test attribute description');
        $attribute->setSortOrder(0);
        $attribute->setCreated(new \DateTime('now', new \DateTimeZone('UTC')));

        $this->assertEquals('Test Attribute', $attribute->getName());
    }

    public function testWithAttributeValues()
    {
        $attribute = new Attribute;
        $attribute->setName('Color');

        $attribute_value_red = new AttributeValue;
        $attribute_value_red->setSku('RED');
        $attribute_value_red->setName('Red');

        $attribute_value_green = new AttributeValue;
        $attribute_value_green->setSku('GRN');
        $attribute_value_green->setName('Green');

        $attribute_value_blue = new AttributeValue;
        $attribute_value_blue->setSku('BLU');
        $attribute_value_blue->setName('Blue');

        $attribute->addAttributeValue($attribute_value_red);
        $attribute->addAttributeValue($attribute_value_green);
        $attribute->addAttributeValue($attribute_value_blue);

        $this->assertEquals('Color', $attribute->getName());
    }
}
