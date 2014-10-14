<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\AttributeValue;

class AttributeValueTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $attribute_value = new AttributeValue;
        $attribute_value->setSku('TA');
        $attribute_value->setName('Test Attribute');
        $attribute_value->setDescription('Test attribute description');
        $attribute_value->setSortOrder(0);
        $attribute_value->setCreated(new \DateTime('now', new \DateTimeZone('UTC')));

        $this->assertEquals('TA', $attribute_value->getSku());
    }
}
