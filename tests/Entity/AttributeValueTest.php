<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\AttributeValue;

class AttributeValueTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->attributeValue = new AttributeValue;
        $this->attributeValue->setSku('TA');
        $this->attributeValue->setName('Test Attribute');
        $this->attributeValue->setDescription('Test attribute description');
        $this->attributeValue->setSortOrder(0);
        $this->attributeValue->setCreated(new \DateTime('now', new \DateTimeZone('UTC')));
    }

    public function testGetters()
    {
        $this->assertEquals(null, $this->attributeValue->getId());
        $this->assertEquals('TA', $this->attributeValue->getSku());
        $this->assertEquals('Test Attribute', $this->attributeValue->getName());
        $this->assertEquals('Test attribute description', $this->attributeValue->getDescription());
        $this->assertEquals(0, $this->attributeValue->getSortOrder());
    }
}
