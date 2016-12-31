<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class AttributeTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $name = 'Test Attribute';
        $sortOrder = 1;
        $attribute = new Attribute($name, $sortOrder);

        $this->assertSame($name, $attribute->getName());
        $this->assertSame($sortOrder, $attribute->getSortOrder());
        $this->assertSame(null, $attribute->getDescription());
        $this->assertSame(0, count($attribute->getAttributeValues()));
    }

    public function testCreate()
    {
        $attributeValue = $this->dummyData->getAttributeValue();

        $attribute = new Attribute('Test Attribute', 1);
        $attribute->setName('Test Attribute2');
        $attribute->setDescription('Test attribute description');
        $attribute->setSortOrder(0);
        $attribute->addAttributeValue($attributeValue);

        $this->assertEntityValid($attribute);
        $this->assertSame('Test Attribute2', $attribute->getName());
        $this->assertSame('Test attribute description', $attribute->getDescription());
        $this->assertSame(0, $attribute->getSortOrder());
        $this->assertSame($attributeValue, $attribute->getAttributeValues()[0]);
    }
}
